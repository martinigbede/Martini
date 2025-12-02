<?php

namespace App\Livewire\Caisse;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\CashAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentReservationModal extends Component
{
    public ?int $reservationId = null;
    public ?Reservation $reservation = null;

    public $paymentAmount = 0;
    public $paymentMode = 'Espèces';

    public $discount = 0;
    public $motifRemise = '';
    public $totalRemise = 0;

    public $totalInvoice;
    public $alreadyPaid;
    public $remaining;

    public $showModal = false; // modifier à false par défaut

    protected $listeners = [
        'openReservationPaymentModal' => 'loadReservation',
        'refreshPaymentModal' => '$refresh',
    ];

    // -------------------------------------------------------------------------
    // MOUNT SUPPRIMÉ OU VIDE pour éviter l'erreur de dépendance
    // -------------------------------------------------------------------------
    public function mount()
    {
        // Ne rien mettre ici, tout sera chargé via le listener
    }

    // -------------------------------------------------------------------------
    // Chargement de la réservation via le listener
    // -------------------------------------------------------------------------
    public function loadReservation($reservationId)
    {
        $this->reservationId = $reservationId;
        $this->loadReservationData();
        $this->showModal = true; // afficher le modal quand on charge
    }

    public function loadReservationData()
    {
        $this->reservation = Reservation::with('rooms', 'payments', 'client', 'invoice')
            ->findOrFail($this->reservationId);

        $invoice = $this->reservation->invoice;

        // Total facture
        $this->totalInvoice = $invoice->montant_final
            ?? $invoice->montant_total
            ?? $this->reservation->total;

        // Déjà payé
        $this->alreadyPaid = $invoice->montant_paye ?? 0;

        // Reste à payer
        $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);

        // Total remises cumulées
        $this->totalRemise = $this->reservation->payments()->sum('remise_amount')
            ?? ($invoice->remise_amount ?? 0);

        // Montant proposé = reste
        $this->paymentAmount = $this->remaining;
    }

    // -------------------------------------------------------------------------
    // Le reste de la logique (settlePayment, applyStatusAccordingToInvoice, closeModal, render)
    // -------------------------------------------------------------------------

    public function settlePayment()
    {
        try {

            // CAS OFFERT
            if ($this->paymentMode === 'Offert') {

                $invoice = $this->reservation->invoice;
                $totalRemise = $invoice ? $invoice->montant_total : 0;

                $this->totalRemise = $totalRemise;

                $this->reservation->payments()->create([
                    'montant' => 0,
                    'mode_paiement' => 'Offert',
                    'statut' => 'Payé',
                    'remise_amount' => $totalRemise,
                    'remise_percent' => 100,
                    'is_remise' => 1,
                    'motif_remise' => $this->motifRemise,
                    'reservation_id' => $this->reservation->id,
                    'user_id' => auth()->id(),
                ]);

                if ($invoice) {
                    $invoice->update([
                        'montant_paye' => 0,
                        'remise_amount' => $totalRemise,
                        'remise_percent' => 100,
                        'montant_final' => 0,
                        'statut' => 'Offerte',
                    ]);
                }

                $this->reservation->update(['statut' => 'Confirmée']);

                foreach ($this->reservation->rooms as $room) {
                    $room->update(['statut' => 'Occupée']);
                }

                session()->flash('success', 'Réservation marquée comme offerte.');
                $this->dispatch('reservationSaved', $this->reservationId);

                return $this->closeModal();
            }

            // CAS NORMAL
            if ($this->paymentAmount <= 0) {
                session()->flash('error', 'Le montant doit être supérieur à 0.');
                return;
            }

            $invoice = $this->reservation->invoice;

            $this->alreadyPaid = $invoice->montant_paye ?? 0;
            $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);

            $discountAmount = max(0, min($this->discount, $this->paymentAmount));
            $finalAmount = $this->paymentAmount - $discountAmount;

            $this->reservation->payments()->create([
                'montant' => $finalAmount,
                'mode_paiement' => $this->paymentMode,
                'statut' => 'Payé',
                'remise_amount' => $discountAmount,
                'remise_percent' => $this->paymentAmount > 0
                    ? round(($discountAmount / $this->paymentAmount) * 100, 2)
                    : 0,
                'is_remise' => $discountAmount > 0 ? 1 : 0,
                'motif_remise' => $this->motifRemise,
                'reservation_id' => $this->reservation->id,
                'user_id' => auth()->id(),
            ]);

            if ($finalAmount > 0) {
                $compte = CashAccount::firstOrCreate(
                    [
                        'type_caisse' => 'Hébergement',
                        'nom_compte' => $this->paymentMode,
                    ],
                    [
                        'solde' => 0,
                    ]
                );

                // Mise à jour du solde via ton MODEL propre
                $compte->addTransaction(
                    amount: $finalAmount,
                    type: 'entree',
                    description: "Paiement réservation #{$this->reservation->id}",
                    userId: auth()->id(),
                );
            }

            if ($invoice) {
                $totalPaid = $this->reservation->payments()->sum('montant');
                $totalRemise = $this->reservation->payments()->sum('remise_amount');

                $montantFinal = max(0, $invoice->montant_total - $totalRemise);

                $statut = $totalPaid >= $montantFinal
                    ? 'Payée'
                    : ($totalPaid > 0 ? 'Partiellement payée' : 'Non payée');

                $invoice->update([
                    'montant_paye' => $totalPaid,
                    'remise_amount' => $totalRemise,
                    'montant_final' => $montantFinal,
                    'statut' => $statut,
                ]);

                $this->applyStatusAccordingToInvoice($statut);
            }

            session()->flash('success', 'Paiement enregistré avec succès.');
            $this->dispatch('reservationSaved', $this->reservationId);

            return $this->closeModal();

        } catch (\Throwable $e) {
            Log::error('Erreur PaymentReservationModal::settlePayment(): '.$e->getMessage());
            session()->flash('error', 'Erreur: '.$e->getMessage());
        }
    }

    private function applyStatusAccordingToInvoice($status)
    {
        if ($status === 'Payée') {
            $this->reservation->update(['statut' => 'Confirmée']);
            foreach ($this->reservation->rooms as $room) {
                $room->update(['statut' => 'Occupée']);
            }
        } elseif ($status === 'Partiellement payée') {
            $this->reservation->update(['statut' => 'En attente']);
            foreach ($this->reservation->rooms as $room) {
                $room->update(['statut' => 'Occupée']);
            }
        } else {
            $this->reservation->update(['statut' => 'En attente']);
            foreach ($this->reservation->rooms as $room) {
                $room->update(['statut' => 'Libre']);
            }
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('refreshReservationManagement');
    }

    public function render()
    {
        return view('livewire.caisse.payment-reservation-modal', [
            'reservation' => $this->reservation,
        ]);
    }
}
