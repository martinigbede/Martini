<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Reservation;
use PDF; // barryvdh/laravel-dompdf
use Illuminate\Support\Facades\Log;

class ReservationDetailsModalPro extends Component
{
    public ?int $reservationId = null;
    public ?Reservation $reservation = null;
    public $showModal = true;

    protected $listeners = [
        'refreshReservationDetails' => '$refresh',
    ];

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;
        $this->loadReservation();
    }

    /**
     * Chargement complet de la réservation + relations nécessaires
     */
    public function loadReservation()
    {
        $this->reservation = Reservation::with([
            'client',
            'rooms.roomType',
            'items.room.roomType',     // ReservationItem + Room + RoomType
            'payments',                // Paiements simples (pas de relation paymentMethod dans ton modèle)
            'invoice',                 // Facture centralisée
            'createdBy',
        ])->findOrFail($this->reservationId);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('refreshReservationManagement');
    }

    /**
     * Génération PDF facture
     */
    public function generateInvoicePDF()
    {
        try {
            $invoice = $this->reservation->invoice;

            $data = [
                'reservation' => $this->reservation,
                'client'      => $this->reservation->client,
                'items'       => $this->reservation->items,
                'rooms'       => $this->reservation->rooms,
                'invoice'     => $invoice,

                // Valeurs dérivées
                'total'       => $invoice->montant_total ?? $this->reservation->total,
                'remise'      => $invoice->remise_amount ?? 0,
                'final'       => $invoice->montant_final ?? $this->reservation->total,
                'paye'        => $invoice->montant_paye ?? $this->reservation->payments->sum('montant'),
                'reste'       => max(0, ($invoice->montant_final ?? $this->reservation->total) - ($invoice->montant_paye ?? 0)),
            ];

            $pdf = PDF::loadView('livewire.reservation.invoice-a5', $data)
                      ->setPaper('a5', 'portrait');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                "facture_reservation_{$this->reservation->id}.pdf"
            );

        } catch (\Throwable $e) {
            Log::error('Erreur ReservationDetailsModalPro::generateInvoicePDF(): '.$e->getMessage());
            session()->flash('error', 'Erreur lors de la génération de la facture.');
        }
    }

    public function render()
    {
        return view('livewire.reservation.reservation-details-modal-pro', [
            'reservation' => $this->reservation,
        ]);
    }
}