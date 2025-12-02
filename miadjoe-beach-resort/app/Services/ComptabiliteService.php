<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\DiversServiceVente;
use App\Models\CashAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ComptabiliteService
{
    protected $dateDebut;
    protected $dateFin;

    public function __construct(string $dateDebut = null, string $dateFin = null)
    {
        $this->dateDebut = $dateDebut ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateFin = $dateFin ?? Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    /**
     * Retourne les totaux globaux et par type.
     */
    public function getTotals(): array
    {
        $paiementsQuery = Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin]);

        // Total par entité
        $totalPaiementsVentesReservations = (clone $paiementsQuery)
            ->where(function ($query) {
                $query->whereNotNull('sale_id')
                      ->orWhereNotNull('reservation_id');
            })->sum('montant');

        $totalPaiementsDivers = (clone $paiementsQuery)
            ->whereNotNull('divers_service_vente_id')
            ->sum('montant');

        $totalPaiements = $totalPaiementsVentesReservations + $totalPaiementsDivers;

        // Totaux factures, ventes, réservations, dépenses
        $totalFactures = Invoice::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant_total');

        $totalReservations = Reservation::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $totalVentes = Sale::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $totalDivers = DiversServiceVente::whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->count();

        $totalDepenses = Expense::where('statut', 'validée')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant');

        $totalEnAttente = Invoice::where('statut', '!=', 'Payée')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->sum('montant_total');

        $soldeNet = $totalPaiements - $totalDepenses;

        return [
            'totalPaiements' => $totalPaiements,
            'totalFactures' => $totalFactures,
            'totalReservations' => $totalReservations,
            'totalVentes' => $totalVentes,
            'totalDivers' => $totalDivers,
            'totalDepenses' => $totalDepenses,
            'soldeNet' => $soldeNet,
            'totalEnAttente' => $totalEnAttente,
        ];
    }

    /**
     * Revenus mensuels pour les graphiques.
     */
    public function getRevenusMensuels()
    {
        $paiements = Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(montant) as total')
            )
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        return $paiements->map(fn($row) => [
            'mois' => Carbon::create()->month($row->mois)->translatedFormat('F'),
            'total' => $row->total,
        ]);
    }

    /**
     * Résumé des paiements par mode.
     */
    public function getResumeModesPaiement(): array
    {
        $paiements = Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin]);

        // Total par mode
        $resume = $paiements
            ->select('mode_paiement', DB::raw('SUM(montant) as total'))
            ->groupBy('mode_paiement')
            ->pluck('total', 'mode_paiement')
            ->toArray();

        return $resume;
    }

    /**
     * KPI par mode de paiement et par entité
     * Retourne une structure :
     * [
     *   'sale' => ['Espèces' => total, 'Carte' => total, ...],
     *   'reservation' => [...],
     *   'divers_service' => [...]
     * ]
     */
    public function getKpiParModeEtEntite(): array
    {
        $paiements = Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->get();

        $kpi = [
            'sale' => [],
            'reservation' => [],
            'divers_service' => [],
        ];

        foreach ($paiements as $payment) {
            $type = 'sale';
            if ($payment->reservation_id) $type = 'reservation';
            if ($payment->divers_service_vente_id) $type = 'divers_service';

            $mode = $payment->mode_paiement ?? 'Autre';

            if (!isset($kpi[$type][$mode])) {
                $kpi[$type][$mode] = 0;
            }

            $kpi[$type][$mode] += $payment->montant;
        }

        return $kpi;
    }

    /**
     * Liste des caisses regroupées.
     */
    public function getCaissesRegroupees()
    {
        $caisses = CashAccount::all()->groupBy('type_caisse');

        return $caisses->map(function ($groupe) {
            $especes = $groupe->where('nom_compte', 'Espèces')->first();
            $mobile = $groupe->where('nom_compte', 'Mobile Money')->first();

            return [
                'type' => $groupe->first()->type_caisse,
                'especes_reel' => ($especes ? $especes->solde : 0) + ($mobile ? $mobile->solde : 0),
                'carte' => optional($groupe->where('nom_compte', 'Carte/TPE')->first())->solde ?? 0,
                'virement' => optional($groupe->where('nom_compte', 'Virement')->first())->solde ?? 0,
            ];
        });
    }

    /**
     * 5 derniers paiements.
     */
    public function getDerniersPaiements(int $limit = 5)
    {
        return Payment::where('statut', 'Payé')->latest()->take($limit)->get();
    }

    /**
     * 5 dernières factures.
     */
    public function getDernieresFactures(int $limit = 5)
    {
        return Invoice::latest()->take($limit)->get();
    }
}
