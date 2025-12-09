<?php

namespace App\Livewire\Sale;

use Livewire\Component;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CashAccount;
use App\Models\Disbursement;
use App\Models\CashAccountTransaction;
use App\Models\HorsVente;
use App\Models\DiversServiceVente;
use App\Models\Expense;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class HistoriquePaiementCaisseSale extends Component
{
    public $payments;
    public $caisseBrute = 0;
    public $expenses = [];

    // KPI Restaurant
    public $kpiEspMomo = 0;
    public $kpiTPE = 0;
    public $kpiVirement = 0;

    public $soldeEspMomo = 0;
    public $soldeTPE = 0;
    public $soldeVirement = 0;
    public $totalExpenses = 0;

    // Filtres
    public $filterDateType = 'jour';
    public $filterMonth;
    public $filterYear;
    public $filterWeek;
    public $filterStartDate;
    public $filterEndDate;
    public $encaissements = [];
    public $caisseHier = ['esp_momo' => 0, 'tpe' => 0, 'virement' => 0,];
    public $activeTab = 'paiements';

    public $filterMode = '';
    public $filterUser = '';
    public $users;
    public $kpiEncaissementsTotal = 0;
    public $flashes = [];

    protected $listeners = [
        'encaissementEffectue' => 'actualiserDonnees',
    ];

    public function actualiserDonnees()
    {
        $this->loadData(); 
    }

    public function mount()
    {
        $this->users = User::select('id','name')->get();
        $this->filterYear = date('Y');
        $this->filterMonth = date('m');
        $this->filterWeek = date('W');

        $this->loadData();
    }

    public function loadData()
    {
        $this->payments = $this->getFilteredPayments();

        // Soldes réels caisse Restaurant
        $this->soldeEspMomo = CashAccount::where('type_caisse', 'Restaurant')
            ->whereIn('nom_compte', ['Espèces','Mobile Money','Mix by Yas','Flooz'])
            ->sum('solde');

        $this->soldeTPE = CashAccount::where('type_caisse', 'Restaurant')
            ->where('nom_compte', 'Carte/TPE')
            ->sum('solde');

        $this->soldeVirement = CashAccount::where('type_caisse', 'Restaurant')
            ->where('nom_compte', 'Virement')
            ->sum('solde');

        // KPI
        $this->kpiEspMomo = $this->payments->whereIn('mode_paiement', ['Espèces', 'Mobile Money','Mix by Yas','Flooz'])->sum('montant');
        $this->kpiTPE = $this->payments->where('mode_paiement', 'Carte/TPE')->sum('montant');
        $this->kpiVirement = $this->payments->where('mode_paiement', 'Virement')->sum('montant');

        // Caisse brute = total des paiements filtrés
        $this->loadExpenses();
        $this->caisseBrute = $this->payments->sum('montant');
        $this->loadEncaissements();
        $this->kpiEncaissementsTotal = collect($this->encaissements)->sum('montant');
        $this->loadCaisseHier();
        $this->encaissements = collect()
            ->merge(Disbursement::whereNotNull('encaisse_at')->get())
            ->merge(HorsVente::all())
            ->sortByDesc('created_at')
            ->values();
    }

    public function loadCaisseHier()
    {
        $hier = date('Y-m-d', strtotime('-1 day'));

        $transactions = CashAccountTransaction::whereHas('cashAccount', function($q) {
                $q->where('type_caisse', 'Restaurant');
            })
            ->whereDate('created_at', '<=', $hier)
            ->get();

        $espMomo = $transactions
            ->whereIn('cashAccount.nom_compte', ['Espèces', 'Mobile Money', 'Mix by Yas','Flooz'])
            ->sum(function($t) { 
                return $t->type_operation === 'entree' ? $t->montant : -$t->montant;
            });

        $tpe = $transactions
            ->where('cashAccount.nom_compte', 'Carte/TPE')
            ->sum(function($t) { 
                return $t->type_operation === 'entree' ? $t->montant : -$t->montant;
            });

        $virement = $transactions
            ->where('cashAccount.nom_compte', 'Virement')
            ->sum(function($t) { 
                return $t->type_operation === 'entree' ? $t->montant : -$t->montant;
            });

        $this->caisseHier = [
            'esp_momo' => $espMomo,
            'tpe' => $tpe,
            'virement' => $virement,
        ];
    }

    public function loadExpenses()
    {
        $query = Expense::query();

        // FILTRE DATE
        switch ($this->filterDateType) {
            case 'jour':
                $query->whereDate('date_depense', date('Y-m-d'));
                break;

            case 'mois':
                $query->whereYear('date_depense', $this->filterYear)
                    ->whereMonth('date_depense', $this->filterMonth);
                break;

            case 'annee':
                $query->whereYear('date_depense', $this->filterYear);
                break;

            case 'semaine':
                $query->whereYear('date_depense', $this->filterYear)
                    ->whereRaw('WEEK(date_depense, 1) = ?', [$this->filterWeek]);
                break;

            case 'perso':
                if ($this->filterStartDate && $this->filterEndDate) {
                    $query->whereBetween('date_depense', [
                        $this->filterStartDate, $this->filterEndDate
                    ]);
                }
                break;
        }

        // FILTRE USER
        if ($this->filterUser) {
            $query->where('user_id', $this->filterUser);
        }

        // Seulement les dépenses validées
        $query->where('statut', 'validée');

        $this->expenses = $query->orderByDesc('date_depense')->get();

        // Total des dépenses
        $this->totalExpenses = $this->expenses->sum('montant');
    }

    public function getFilteredPayments()
    {
        // Rôles autorisés pour voir divers services côté Restaurant
        $allowedRoles = ['Direction', 'Comptable', 'Restauration', 'Caisse'];

        $query = Payment::with(['sale', 'reservation', 'user']);

        // FILTRE DATE
        switch ($this->filterDateType) {
            case 'jour':
                $query->whereDate('created_at', date('Y-m-d'));
                break;
            case 'mois':
                $query->whereYear('created_at', $this->filterYear)
                      ->whereMonth('created_at', $this->filterMonth);
                break;
            case 'annee':
                $query->whereYear('created_at', $this->filterYear);
                break;
            case 'semaine':
                $query->whereYear('created_at', $this->filterYear)
                      ->whereRaw('WEEK(created_at, 1) = ?', [$this->filterWeek]);
                break;
            case 'perso':
                if ($this->filterStartDate && $this->filterEndDate) {
                    $query->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
                }
                break;
        }

        // FILTRE MODE
        if ($this->filterMode) {
            $query->where('mode_paiement', $this->filterMode);
        }

        // FILTRE USER
        if ($this->filterUser) {
            $query->where('user_id', $this->filterUser);
        }

        // encaissements liés à des décaissements (via sale->reservation)
        $query->where(function($q) use ($allowedRoles) {
            $q->whereNotNull('sale_id') // paiements de vente
              ->orWhere(function($sub) use ($allowedRoles) {
                  $sub->whereNotNull('divers_service_vente_id')
                      ->whereHas('user.roles', function($r) use ($allowedRoles) {
                          $r->whereIn('name', $allowedRoles);
                      });
              });
        });

        return $query->orderBy('created_at','desc')->get();
    }

    public function loadEncaissements()
    {
        // Encaissements normaux
        $query = Disbursement::with(['reservation', 'encaisseur'])
            ->where('est_encaisse', true);

        switch ($this->filterDateType) {
            case 'jour':
                $query->whereDate('encaisse_at', now()->toDateString());
                break;
            case 'mois':
                $query->whereYear('encaisse_at', $this->filterYear)
                    ->whereMonth('encaisse_at', $this->filterMonth);
                break;
            case 'annee':
                $query->whereYear('encaisse_at', $this->filterYear);
                break;
            case 'semaine':
                $query->whereYear('encaisse_at', $this->filterYear)
                    ->whereRaw('WEEK(encaisse_at, 1) = ?', [$this->filterWeek]);
                break;
            case 'perso':
                if ($this->filterStartDate && $this->filterEndDate) {
                    $query->whereBetween('encaisse_at', [$this->filterStartDate, $this->filterEndDate]);
                }
                break;
        }

        if ($this->filterUser) {
            $query->where('encaisse_user_id', $this->filterUser);
        }

        $this->encaissements = $query->orderByDesc('created_at')->get();

        $encaissementsNormaux = $query->orderByDesc('encaisse_at')->get()->map(function ($e) {
            return [
                'id' => $e->id,
                'type' => 'normal',
                'date' => $e->encaisse_at,
                'montant' => $e->montant,
                'reference' => $e->reservation_id ? 'Réservation #'.$e->reservation_id : null,
                'decaisseur' => $e->user->name ?? null,
                'encaisseur' => $e->encaisseur->name ?? null,
                'mode' => $e->cashAccount->nom_compte ?? null,
            ];
        });

        // Encaissements hors vente
        $hvQuery = HorsVente::with('user');

        switch ($this->filterDateType) {
            case 'jour':
                $hvQuery->whereDate('created_at', date('Y-m-d'));
                break;
            case 'mois':
                $hvQuery->whereYear('created_at', $this->filterYear)
                        ->whereMonth('created_at', $this->filterMonth);
                break;
            case 'annee':
                $hvQuery->whereYear('created_at', $this->filterYear);
                break;
            case 'semaine':
                $hvQuery->whereYear('created_at', $this->filterYear)
                        ->whereRaw('WEEK(created_at, 1) = ?', [$this->filterWeek]);
                break;
            case 'perso':
                if ($this->filterStartDate && $this->filterEndDate) {
                    $hvQuery->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
                }
                break;
        }

        if ($this->filterUser) {
            $hvQuery->where('user_id', $this->filterUser);
        }

        $encaissementsHors = $hvQuery->orderByDesc('created_at')->get()->map(function ($hv) {
            return [
                'id' => $hv->id,
                'type' => 'horsvente',
                'date' => $hv->created_at,
                'montant' => $hv->montant,
                'reference' => 'Hors Vente',
                'decaisseur' => null,
                'encaisseur' => $hv->user->name ?? null,
                'mode' => $hv->mode_paiement,
            ];
        });

        // Fusionner (maintenant ce sont des tableaux, Livewire accepte)
        $this->encaissements = collect($encaissementsNormaux)
            ->concat($encaissementsHors)
            ->sortByDesc('date')
            ->values();
    }

    public function getDisbursementEncaissements()
    {
        $query = Disbursement::with(['reservation', 'encaisseur'])
            ->where('est_encaisse', true);

        // FILTRE DATE
        switch ($this->filterDateType) {
            case 'jour':
                $query->whereDate('encaisse_at', date('Y-m-d'));
                break;
            case 'mois':
                $query->whereYear('encaisse_at', $this->filterYear)
                    ->whereMonth('encaisse_at', $this->filterMonth);
                break;

            case 'annee':
                $query->whereYear('encaisse_at', $this->filterYear);
                break;

            case 'semaine':
                $query->whereYear('encaisse_at', $this->filterYear)
                    ->whereRaw('WEEK(encaisse_at, 1) = ?', [$this->filterWeek]);
                break;

            case 'perso':
                if ($this->filterStartDate && $this->filterEndDate) {
                    $query->whereBetween('encaisse_at', [
                        $this->filterStartDate,
                        $this->filterEndDate
                    ]);
                }
                break;
        }

        // FILTRE UTILISATEUR (encaisseur)
        if ($this->filterUser) {
            $query->where('encaisse_user_id', $this->filterUser);
        }

        return $query->orderByDesc('encaisse_at')->get();
    }

    public function exportPdf()
    {
        // * 1. Charger les ventes + items
        $sales = Sale::with(['items.menu', 'payments'])
            ->when($this->filterDateType === 'jour', fn($q) =>
                $q->whereDate('date', date('Y-m-d'))
            )
            ->when($this->filterDateType === 'mois', fn($q) =>
                $q->whereYear('date', $this->filterYear)
                    ->whereMonth('date', $this->filterMonth)
            )
            ->when($this->filterDateType === 'annee', fn($q) =>
                $q->whereYear('date', $this->filterYear)
            )
            ->when($this->filterDateType === 'semaine', fn($q) =>
                $q->whereYear('date', $this->filterYear)
                    ->whereRaw('WEEK(date, 1) = ?', [$this->filterWeek])
            )
            ->when($this->filterDateType === 'perso', fn($q) =>
                $q->whereBetween('date', [$this->filterStartDate, $this->filterEndDate])
            )
            ->get();

        // * 2. Récupérer les paiements filtrés
        $payments = $this->getFilteredPayments();

        // * 3. Encaissements (normaux + hors vente)
        $this->loadEncaissements();
        $encaissements = $this->encaissements;

        // * 4. Dépenses filtrées
        $this->loadExpenses();
        $expenses = $this->expenses;

        // *** AJOUT : Récupération des DiversServiceVente créés par des users avec rôle "Restauration"
        $diversServices = DiversServiceVente::with(['items.service', 'user', 'payments', 'invoice'])
            ->whereHas('user.roles', function ($q) {
                $q->where('name', 'Restauration'); // Filtre le rôle du user qui a créé la vente
            })
            ->when($this->filterDateType === 'jour', fn($q) =>
                $q->whereDate('created_at', date('Y-m-d'))
            )
            ->when($this->filterDateType === 'mois', fn($q) =>
                $q->whereYear('created_at', $this->filterYear)
                    ->whereMonth('created_at', $this->filterMonth)
            )
            ->when($this->filterDateType === 'annee', fn($q) =>
                $q->whereYear('created_at', $this->filterYear)
            )
            ->when($this->filterDateType === 'semaine', fn($q) =>
                $q->whereYear('created_at', $this->filterYear)
                    ->whereRaw('WEEK(created_at, 1) = ?', [$this->filterWeek])
            )
            ->when($this->filterDateType === 'perso', fn($q) =>
                $q->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate])
            )
            ->get();

        // Fusion des items et paiements
        $diversServiceItems = $diversServices->flatMap->items;
        $diversServicePayments = $diversServices->flatMap->payments;

        // * 5. Synthèse KPI
        $kpiEspMomo = $payments->whereIn('mode_paiement', [
                'Espèces','Mobile Money','Mix by Yas','Flooz'
            ])->sum('montant');

        $kpiTPE = $payments->where('mode_paiement', 'Carte/TPE')->sum('montant');
        $kpiVirement = $payments->where('mode_paiement', 'Virement')->sum('montant');

        $caisseBrute = $payments->sum('montant');
        $totalExpenses = $expenses->sum('montant');
        $soldeNet = $caisseBrute - $totalExpenses;

        // * 6. Préparer les données pour la vue PDF
        $data = [
            'payments' => $payments,
            'totalPayments' => $payments->sum('montant'),

            // Divers Services filtrés
            'diversServices' => $diversServices,
            'diversServiceItems' => $diversServiceItems,
            'diversServicePayments' => $diversServicePayments,
            'totalDiversPayments' => $diversServicePayments->sum('montant'),

            // Ventes Restaurant
            'sales' => $sales,
            'saleItems' => $sales->flatMap->items,

            // Encaissements
            'encaissements' => $encaissements,

            // Dépenses
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,

            // Synthèse KPI
            'caisseBrute' => $caisseBrute,
            'soldeNet' => $soldeNet,
            'kpiEspMomo' => $kpiEspMomo,
            'kpiTPE' => $kpiTPE,
            'kpiVirement' => $kpiVirement,

            // Filtres actifs
            'filterDateType' => $this->filterDateType,
            'filterMonth' => $this->filterMonth,
            'filterWeek' => $this->filterWeek,
            'filterYear' => $this->filterYear,
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,

            // Date édition
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        // * 7. Génération du PDF
        $pdf = \PDF::loadView('pdf.rapport-caisse-restaurant', $data)
                    ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'rapport_caisse_restaurant.pdf'
        );
    }

    public function render()
    {
        return view('livewire.sale.historique-paiement-caisse-sale', [
            'payments' => $this->payments,
            'caisseBrute' => $this->caisseBrute,
            'kpiEspMomo' => $this->kpiEspMomo,
            'kpiTPE' => $this->kpiTPE,
            'kpiVirement' => $this->kpiVirement,
            'encaissements' => $this->encaissements,
            'expenses' => $this->expenses, 
            'totalExpenses' => $this->totalExpenses, 

            'soldeEspMomo' => $this->soldeEspMomo,
            'soldeTPE' => $this->soldeTPE,
            'soldeVirement' => $this->soldeVirement,
            'caisseHier' => $this->caisseHier,
            'users' => $this->users,
        ]);
    }
}