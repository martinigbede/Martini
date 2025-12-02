<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        $mail = $this->subject("Confirmation de votre réservation")
            ->view('emails.reservation.confirmed')
            ->with(['reservation' => $this->reservation]);

        // Générer PDF (optionnel)
        $pdf = \PDF::loadView('pdfs.invoice', ['reservation' => $this->reservation]);
        $path = storage_path('app/invoices/invoice_' . $this->reservation->id . '.pdf');
        \Storage::put('invoices/invoice_' . $this->reservation->id . '.pdf', $pdf->output());

        $mail->attach($path);

        return $mail;
    }
}
