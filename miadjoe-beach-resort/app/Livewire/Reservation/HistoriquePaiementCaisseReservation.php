<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Payment;
use App\Models\User;
use App\Models\CashAccount;
use App\Models\CashAccountTransaction;
use Illuminate\Support\Facades\DB;

class HistoriquePaiementCaisseReservation extends Component
{
    public $payments;
    public $caisseBrute = 0;

    // KPI et soldes
    public $kpiEspMomo = 0;
    public $kpiTPE = 0;
    public $kpiVirement = 0;

    public $soldeEspMomo = 0;
    public $soldeTPE = 0;
    public $soldeVirement = 0;

    // Filtres
    public $filterDateType = 'jour';
    public $filterMonth;
    public $filterYear;
    public $filterWeek;
    public $filterStartDate;
    public $filterEndDate;
    public $caisseHier = ['esp_momo' => 0, 'tpe' => 0, 'virement' => 0,];

    public $filterMode = '';
    public $filterUser = '';
    public $users;

    // Encaissements
    public $encaissements;

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
        // Récupération des paiements filtrés
        $this->payments = $this->getFilteredPayments();

        // Soldes réels par mode de paiement (caisse)
        $this->soldeEspMomo = CashAccount::where('type_caisse', 'Hébergement')
            ->whereIn('nom_compte', ['Espèces','Mobile Money'])
            ->sum('solde');

        $this->soldeTPE = CashAccount::where('type_caisse', 'Hébergement')
            ->where('nom_compte', 'Carte/TPE')
            ->sum('solde');

        $this->soldeVirement = CashAccount::where('type_caisse', 'Hébergement')
            ->where('nom_compte', 'Virement')
            ->sum('solde');

        // KPI basés sur les paiements filtrés
        $this->kpiEspMomo = $this->payments->whereIn('mode_paiement', ['Espèces', 'Mobile Money'])->sum('montant');
        $this->kpiTPE = $this->payments->where('mode_paiement', 'Carte/TPE')->sum('montant');
        $this->kpiVirement = $this->payments->where('mode_paiement', 'Virement')->sum('montant');

        // Caisse brute sur tous les paiements filtrés
        $this->caisseBrute = $this->payments->sum('montant');

        $this->loadCaisseHier();
    }

    public function loadCaisseHier()
    {
        $hier = date('Y-m-d', strtotime('-1 day'));

        $transactions = CashAccountTransaction::whereHas('cashAccount', function($q) {
                $q->where('type_caisse', 'Hébergement');
            })
            ->whereDate('created_at', '<=', $hier)
            ->get();

        $espMomo = $transactions
            ->whereIn('cashAccount.nom_compte', ['Espèces', 'Mobile Money'])
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

    public function getFilteredPayments()   
    {
        $allowedRoles = ['Direction', 'Comptable', 'Réception', 'Caisse'];
        $query = Payment::with(['reservation.client', 'user']);

        // Filtre date
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

        // Filtre mode de paiement
        if ($this->filterMode) {
            $query->where('mode_paiement', $this->filterMode);
        }

        // Filtre utilisateur
        if ($this->filterUser) {
            $query->where('user_id', $this->filterUser);
        }

        // Paiements réservations et services divers
        $query->where(function($q) use ($allowedRoles) {
            $q->whereNotNull('reservation_id')
              ->orWhere(function($sub) use ($allowedRoles) {
                  $sub->whereNotNull('divers_service_vente_id')
                      ->whereHas('user.roles', function($roleQuery) use ($allowedRoles) {
                          $roleQuery->whereIn('name', $allowedRoles);
                      });
              });
        });

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function exportPdf()
    {
        $data = [
            'payments' => $this->payments,
            'caisseBrute' => $this->caisseBrute,
            'kpiEspMomo' => $this->kpiEspMomo,
            'kpiTPE' => $this->kpiTPE,
            'kpiVirement' => $this->kpiVirement,
            'filterDateType' => $this->filterDateType,
            'filterMonth' => $this->filterMonth,
            'filterWeek' => $this->filterWeek,
            'filterYear' => $this->filterYear,
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,
        ];

        $pdf = \PDF::loadView('pdf.historique-paiements-reservation', $data)
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'historique_paiements_reservation.pdf'
        );
    }

    public function render()
    {
        return view('livewire.reservation.historique-paiement-caisse-reservation', [
            'payments' => $this->payments,
            'caisseBrute' => $this->caisseBrute,
            'kpiEspMomo' => $this->kpiEspMomo,
            'kpiTPE' => $this->kpiTPE,
            'kpiVirement' => $this->kpiVirement,
            'soldeEspMomo' => $this->soldeEspMomo,
            'soldeTPE' => $this->soldeTPE,
            'soldeVirement' => $this->soldeVirement,
            'caisseHier' => $this->caisseHier,
            'users' => $this->users,
        ]);
    }
}
