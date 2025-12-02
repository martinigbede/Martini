<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\CashAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentSettlementModalPro extends Component
{
    public ?int $reservationId = null;
    public ?Reservation $reservation = null;

    public $paymentAmount = 0;
    public $paymentMode = 'Espèces';
    public $newCheckOut;
    public $discount = 0; // remise en %
    public $motifRemise = '';
    public $totalRemise = 0;

    public $totalInvoice;
    public $alreadyPaid;
    public $remaining;

    public $showModal = true;

    protected $listeners = [
        'refreshPaymentModal' => '$refresh',
    ];

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;
        $this->loadReservation();
    }

    public function loadReservation()
    {
        $this->reservation = Reservation::with('rooms', 'payments', 'client', 'invoice')
            ->findOrFail($this->reservationId);

        $invoice = $this->reservation->invoice;

        $this->totalInvoice = $invoice->montant_final
            ?? $invoice->montant_total
            ?? $this->reservation->total;

        $this->alreadyPaid = $invoice->montant_paye ?? 0;

        $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);
        $this->totalRemise = $this->reservation->payments()->sum('remise_amount') ?? ($invoice->remise_amount ?? 0);

        $this->paymentAmount = $this->remaining;
        $this->newCheckOut = $this->reservation->check_out;
    }

    public function updatedNewCheckOut()
    {
        if ($this->newCheckOut && $this->newCheckOut > $this->reservation->check_out) {
            $daysDiff = Carbon::parse($this->reservation->check_out)->diffInDays(Carbon::parse($this->newCheckOut));
            $this->paymentAmount += $daysDiff * $this->reservation->rooms->sum(fn($room) => $room->roomType->prix_base);
        }
    }

    public function settlePayment()
    {
        try {
            // -------------------------------
            // Cas "Offert"
            // -------------------------------
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

                foreach ($this->reservation->items as $item) {
                    if ($item->room) {
                        $item->room->update(['statut' => 'Occupée']);
                    }
                }

                session()->flash('success', 'Réservation marquée comme offerte avec succès !');
                $this->dispatch('reservationSaved', $this->reservationId);
                return $this->closeModal();
            }

            // -------------------------------
            // Cas normal
            // -------------------------------
            if ($this->paymentAmount <= 0) {
                session()->flash('error', 'Le montant doit être supérieur ou égal à 0.');
                return;
            }

            $this->alreadyPaid = $this->reservation->invoice->montant_paye ?? 0;
            $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);

            $discountAmount = max(0, min($this->discount, $this->paymentAmount));
            $finalAmount = $this->paymentAmount - $discountAmount;

            // -------------------------------
            // Enregistrement du paiement normal
            // -------------------------------
            $payment = $this->reservation->payments()->create([
                'montant' => $finalAmount,
                'mode_paiement' => $this->paymentMode,
                'statut' => 'Payé',
                'remise_amount' => $discountAmount,
                'remise_percent' => $this->paymentAmount > 0 ? round(($discountAmount / $this->paymentAmount) * 100, 2) : 0,
                'is_remise' => $discountAmount > 0 ? 1 : 0,
                'motif_remise' => $this->motifRemise,
                'reservation_id' => $this->reservation->id,
                'user_id' => auth()->id(),
            ]);

            // -------------------------------
            // Ajouter le paiement dans la caisse correspondante
            // -------------------------------
            if ($finalAmount > 0 && $this->paymentMode !== 'Offert') {
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

            // -------------------------------
            // Mise à jour date de départ si prolongation
            // -------------------------------
            if ($this->newCheckOut && $this->newCheckOut > $this->reservation->check_out) {
                $this->reservation->update(['check_out' => $this->newCheckOut]);
            }

            // -------------------------------
            // Mise à jour de la facture
            // -------------------------------
            if ($this->reservation->invoice) {
                $invoice = $this->reservation->invoice;

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

            session()->flash('success', 'Paiement enregistré avec succès !');
            $this->dispatch('reservationSaved', $this->reservationId);
            return $this->closeModal();

        } catch (\Throwable $e) {
            Log::error('Erreur PaymentSettlementModalPro::settlePayment(): '.$e->getMessage());
            session()->flash('error', 'Une erreur est survenue : '.$e->getMessage());
        }

        if ($this->reservation->invoice->statut === 'Offerte') {
            session()->flash('error', 'Cette réservation est déjà OFFERTE, aucune modification possible.');
            return;
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
        return view('livewire.reservation.payment-settlement-modal-pro', [
            'reservation' => $this->reservation,
        ]);
    }
}
