<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Disbursement;
use App\Models\CashAccount;
use Illuminate\Support\Facades\Auth;

class ReservationDisbursementManagement extends Component
{
    public $reservations;

    public function mount()
    {
        $this->loadReservations();
    }

    public function loadReservations()
    {
        $this->reservations = Reservation::with(['sales', 'disbursements', 'client', 'payments'])->get();
    }

    public function getTotalVentes($reservation)
    {
        return $reservation->sales->sum('total');
    }

    public function getTotalDecaissements($reservation)
    {
        return $reservation->disbursements->sum('montant');
    }

    public function getResteADecaisser($reservation)
    {
        return max(0, $this->getTotalVentes($reservation) - $this->getTotalDecaissements($reservation));
    }

    public function decaisser($reservationId)
    {
        $reservation = Reservation::with(['sales','disbursements','payments'])->findOrFail($reservationId);

        // Vérifier paiement complet
        $totalVentes = $reservation->sales->sum('total');
        $totalPayes = $reservation->payments->sum('montant');

        if ($totalPayes < $totalVentes) {
            session()->flash('error', "La réservation n’est pas entièrement payée, décaissement impossible.");
            return;
        }

        // Calcul reste à décaisser
        $dejaDecaisse = $reservation->disbursements->sum('montant');
        $reste = $totalVentes - $dejaDecaisse;

        if ($reste <= 0) {
            session()->flash('error', "Décaissement déjà effectué.");
            return;
        }

        // Identifier le compte de caisse à débiter
        $modePaiement = $reservation->payments->first()->mode_paiement ?? 'Espèces'; // par défaut Espèces
        $compte = null;

        switch ($modePaiement) {
            case 'Espèces':
            case 'Mobile Money':
                $compte = CashAccount::where('type_caisse','Hébergement')
                                    ->whereIn('nom_compte',['Espèces','Mobile Money'])
                                    ->first();
                break;

            case 'Carte':
            case 'TPE':
                $compte = CashAccount::where('type_caisse','Hébergement')
                                    ->where('nom_compte','Carte/TPE')
                                    ->first();
                break;

            case 'Virement':
                $compte = CashAccount::where('type_caisse','Hébergement')
                                    ->where('nom_compte','Virement')
                                    ->first();
                break;

            case 'Offert':
                session()->flash('info', "Décaissement non nécessaire (Offert).");
                return;

            default:
                session()->flash('error', "Mode de paiement inconnu !");
                return;
        }

        // Vérifier si le compte existe
        if (!$compte) {
            session()->flash('error', "Compte de caisse introuvable pour le mode de paiement : {$modePaiement}");
            return;
        }

        // Vérifier solde disponible
        if ($compte->solde < $reste) {
            session()->flash('error', "Solde insuffisant dans le compte {$compte->nom_compte} !");
            return;
        }

        // Débiter le compte
        $compte->solde -= $reste;
        $compte->save();
        //Créer la transaction dans CashAccountTransaction
        $compte->addTransaction(
            amount: $reste,
            type: 'sortie',
            description: "Décaissement réservation #{$reservation->id}",
            userId: Auth::id()
        );

        // Créer le décaissement
        Disbursement::create([
            'reservation_id' => $reservation->id,
            'montant' => $reste,
            'user_id' => Auth::id(),
            'cash_account_id' => $compte->id,
        ]);

        session()->flash('success', "Décaissement de ".number_format($reste,0,',',' ')." FCFA effectué !");
        $this->loadReservations();
    }

    public function render()
    {
        return view('livewire.reservation.reservation-disbursement-management', [
            'reservations' => $this->reservations
        ]);
    }
}