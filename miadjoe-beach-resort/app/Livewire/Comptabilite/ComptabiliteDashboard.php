<?php

namespace App\Livewire\Comptabilite;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\DiversServiceVente;
use App\Models\CashAccount;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ComptabiliteDashboard extends Component
{
    public $periode = 'mois';
    public $dateDebut;
    public $dateFin;

    public $totalPaiements = 0;
    public $totalFactures = 0;
    public $totalReservations = 0;
    public $totalVentes = 0;
    public $totalDivers = 0;
    public $totalDepenses = 0;
    //public $soldeNet = 0;
    public $totalEnAttente = 0;

    public $revenusMensuels = [];
    public $resumeModesPaiement = [];
    public $caissesRegroupees = [];
    public $caisses = [];

    protected $listeners = ['refresh-data' => '$refresh', 'refresh-data' => 'actualiserComptabilite', 'open-hors-vente-modal' => 'openModal'];

    public function mount()
    {
        $this->dateDebut = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateFin = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->chargerStatistiques();
        $this->chargerCaissesRegroupees();
    }

    public function actualiserComptabilite()
    {
        // Recharge les statistiques globales
        $this->chargerStatistiques();

        // Recharge les caisses regroupées
        $this->chargerCaissesRegroupees();
    }

    public function chargerCaissesRegroupees()
    {
        $caisses = CashAccount::all()->groupBy('type_caisse');

        $this->caissesRegroupees = $caisses->map(function ($groupe) {

            $especes = $groupe->where('nom_compte', 'Espèces')->first();
            $mobile = $groupe->where('nom_compte', 'Mobile Money')->first();
            $flooz = $groupe->where('nom_compte', 'Flooz')->first();
            $mix = $groupe->where('nom_compte', 'Mix by Yas')->first();

            return [
                'type' => $groupe->first()->type_caisse,

                'especes_reel' => ($especes ? $especes->solde : 0) + ($mobile ? $mobile->solde : 0) + ($flooz ? $flooz->solde : 0) + ($mix ? $mix->solde : 0),

                'carte' => optional($groupe->where('nom_compte', 'Carte/TPE')->first())->solde ?? 0,
                'virement' => optional($groupe->where('nom_compte', 'Virement')->first())->solde ?? 0,
            ];
        });
    }

    public function updatedPeriode()
    {
        if ($this->periode === 'mois') {
            $this->dateDebut = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->dateFin = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($this->periode === 'annee') {
            $this->dateDebut = Carbon::now()->startOfYear()->format('Y-m-d');
            $this->dateFin = Carbon::now()->endOfYear()->format('Y-m-d');
        } elseif ($this->periode === 'jour') {
            $this->dateDebut = Carbon::today()->format('Y-m-d');
            $this->dateFin = Carbon::today()->format('Y-m-d');
        }

        $this->chargerStatistiques();
    }

    public function updatedDateDebut()
    {
        $this->chargerStatistiques();
    }

    public function updatedDateFin()
    {
        $this->chargerStatistiques();
    }

    public function chargerStatistiques()
    {
        $paiements = Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin]);

        
        $totalPaiementsReservations = (clone $paiements)
            ->whereNotNull('reservation_id')
            ->sum('montant');

        $totalPaiementsVentes = (clone $paiements)
            ->whereNotNull('sale_id')
            ->sum('montant');

        $totalPaiementsDivers = (clone $paiements)
            ->whereNotNull('divers_service_vente_id')
            ->sum('montant');

        $this->totalPaiements = $totalPaiementsVentes + $totalPaiementsReservations + $totalPaiementsDivers ;

        $this->totalFactures = Invoice::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant_final');

        $this->totalReservations = Reservation::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $this->totalVentes = Sale::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $this->totalDivers = DiversServiceVente::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $this->totalDepenses = Expense::where('statut', 'validée')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant');

        $this->totalEnAttente = Invoice::where('statut', '!=', 'Payée')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant_final');

        //$this->soldeNet = $this->totalPaiements - $this->totalDepenses;

        $this->revenusMensuels = (clone $paiements)
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(montant) as total')
            )
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->map(fn($row) => [
                'mois' => Carbon::create()->month($row->mois)->translatedFormat('F'),
                'total' => $row->total,
            ]);

        $this->resumeModesPaiement = (clone $paiements)
            ->select('mode_paiement', DB::raw('SUM(montant) as total'))
            ->groupBy('mode_paiement')
            ->pluck('total', 'mode_paiement')
            ->toArray();

        $this->caisses = CashAccount::select('id', 'nom_compte', 'type_caisse', 'solde')->get();
    }

    public function exportExcel()
    {
        $this->chargerStatistiques();

        $data = [];

        // ===== 1. Résumé Général =====
        $data[] = ['Résumé Général'];
        $data[] = ['Total Paiements', number_format($this->totalPaiements, 0, ',', ' ') . ' FCFA'];
        $data[] = ['Total Factures', number_format($this->totalFactures, 0, ',', ' ') . ' FCFA'];
        $data[] = ['Total Réservations', $this->totalReservations];
        $data[] = ['Total Ventes', $this->totalVentes];
        $data[] = ['Total Divers', $this->totalDivers];
        $data[] = ['Total Dépenses', number_format($this->totalDepenses, 0, ',', ' ') . ' FCFA'];
        $data[] = ['Total En Attente', number_format($this->totalEnAttente, 0, ',', ' ') . ' FCFA'];
        $data[] = [];

        // ===== 2. Caisses Détails =====
        $data[] = ['Caisses par Type'];
        foreach ($this->caisses->groupBy('type_caisse') as $type => $caisses) {
            $data[] = ["Type de caisse: {$type}"];
            $data[] = ['Nom Compte', 'Solde'];
            foreach ($caisses as $c) {
                $data[] = [
                    $c->nom_compte,
                    number_format($c->solde, 0, ',', ' ') . ' FCFA'
                ];
            }
            // Sous-total par type
            $totalType = $caisses->sum('solde');
            $data[] = ['Total ' . $type, number_format($totalType, 0, ',', ' ') . ' FCFA'];
            $data[] = [];
        }

        // ===== 3. Revenus Mensuels =====
        $data[] = ['Revenus Mensuels'];
        $data[] = ['Mois', 'Montant'];
        foreach ($this->revenusMensuels as $row) {
            $data[] = [$row['mois'], number_format($row['total'], 0, ',', ' ') . ' FCFA'];
        }
        $data[] = [];

        // ===== 4. Paiements Détail =====
        $paiements = \App\Models\Payment::where('statut', 'Payé')
                        ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                        ->get();

        $data[] = ['Paiements Détail'];
        $data[] = ['ID', 'Montant', 'Mode', 'Réservation', 'Vente', 'Divers', 'Date'];
        foreach ($paiements as $p) {
            $data[] = [
                $p->id,
                number_format($p->montant, 0, ',', ' ') . ' FCFA',
                $p->mode_paiement,
                $p->reservation_id,
                $p->sale_id,
                $p->divers_service_vente_id,
                $p->created_at->format('Y-m-d H:i')
            ];
        }

        // ===== 5. Décaissements/Encaissements =====
        $decaissements = \App\Models\Disbursement::whereBetween('created_at', [$this->dateDebut, $this->dateFin])->get();
        $data[] = [];
        $data[] = ['Décaissements / Encaissements'];
        $data[] = ['ID', 'Montant', 'Motif', 'Type', 'Encaisse', 'Date'];
        foreach ($decaissements as $d) {
            $data[] = [
                $d->id,
                number_format($d->montant, 0, ',', ' ') . ' FCFA',
                $d->motif,
                optional($d->cashAccount)->nom_compte,
                $d->est_encaisse ? 'Oui' : 'Non',
                $d->created_at->format('Y-m-d H:i')
            ];
        }

        return Excel::download(new \App\Exports\ComptaExport($data), "rapport_comptable_{$this->dateDebut}_{$this->dateFin}.xlsx");
    }

    public function exportPDF()
    {
        $this->chargerStatistiques();

        // Paiements
        $paiements = \App\Models\Payment::where('statut','Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->get();

        // Dépenses
        $depenses = Expense::whereBetween('date_depense', [$this->dateDebut, $this->dateFin])
            ->orderBy('date_depense')
            ->get();

        // Hors ventes (nouveau)
        $horsVentes = \App\Models\HorsVente::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->orderBy('created_at')
            ->get();

        // Revenus par type
        $revenusParType = [
            'Global' => $paiements->sum('montant') + $horsVentes->sum('montant'),
            'Hébergement' => $paiements->whereNotNull('reservation_id')->sum('montant'),
            'Restaurant' => $paiements->whereNotNull('sale_id')->sum('montant'),
            'Divers' => $paiements->whereNotNull('divers_service_vente_id')->sum('montant'),
            'Hors Vente' => $horsVentes->sum('montant'),
        ];

        // Décaissements
        $decaissements = \App\Models\Disbursement::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->get();

        // Génération PDF
        $pdf = Pdf::loadView('exports.comptable-pdf', [
            'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin,
            'totaux' => [
                'paiements' => $paiements->sum('montant'),
                'factures' => $this->totalFactures,
                'reservations' => $this->totalReservations,
                'ventes' => $this->totalVentes,
                'divers' => $this->totalDivers,
                'depenses' => $this->totalDepenses,
                'en_attente' => $this->totalEnAttente,
                'hors_vente' => $horsVentes->sum('montant'),
            ],
            'caisses' => $this->caisses->groupBy('type_caisse'),
            'revenusMensuels' => $this->revenusMensuels,
            'paiements' => $paiements,
            'decaissements' => $decaissements,
            'revenusParType' => $revenusParType,
            'depenses' => $depenses,
            'horsVentes' => $horsVentes, // ajout important
        ])->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "rapport_comptable_{$this->dateDebut}_{$this->dateFin}.pdf"
        );
    }

    public function calculerRevenusParCaisse()
    {
        $revenus = [];

        $types = ['Restaurant', 'Hébergement'];

        foreach ($types as $type) {
            $caisses = CashAccount::where('type_caisse', $type)->get();

            if ($type === 'Restaurant') {
                // Revenu = Espèces + Mobile Money - Dépenses
                $soldeEspeces = optional($caisses->where('nom_compte','Espèces')->first())->solde ?? 0;
                $soldeMobile = optional($caisses->where('nom_compte','Mobile Money')->first())->solde ?? 0;

                $depenses = Expense::where('statut','validée')
                            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                            ->sum('montant');

                $revenus[$type] = ($soldeEspeces + $soldeMobile) - $depenses;

            } else {
                // Hébergement : somme des ventes / paiements
                $revenus[$type] = Payment::where('statut', 'Payé')
                                    ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                                    ->whereHas('reservation', function($q){
                                        $q->where('type_caisse','Hébergement');
                                    })
                                    ->sum('montant');
            }
        }

        return $revenus;
    }

    public function viderCaisse($typeCaisse, $nomCompte)
    {
        $caisse = CashAccount::where('type_caisse', $typeCaisse)
                            ->where('nom_compte', $nomCompte)
                            ->first();

        if ($caisse && $caisse->solde > 0) {
            $montant = $caisse->solde;

            // Remise à zéro
            $caisse->solde = 0;
            $caisse->save();

            // Recalcul des caisses pour le rendu
            $this->chargerCaissesRegroupees();

            // Flash message success
            session()->flash('success', "La caisse {$nomCompte} ({$typeCaisse}) a été vidée ({$montant}).");
        } else {
            // Flash message info si déjà vide
            session()->flash('info', "La caisse {$nomCompte} ({$typeCaisse}) est déjà vide.");
        }
    }

    public function render()
    {
        $derniersPaiements = Payment::where('statut', 'Payé')->latest()->take(5)->get();
        $dernieresFactures = Invoice::latest()->take(5)->get();

        return view('livewire.comptabilite.comptabilite-dashboard', [
            'derniersPaiements' => $derniersPaiements,
            'dernieresFactures' => $dernieresFactures,
            'caisses' => $this->caisses,
            
        ]);
    }
}