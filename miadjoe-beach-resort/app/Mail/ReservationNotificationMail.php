<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $reservation;
    public $attachmentPath; // 🔥 AJOUT

    /**
     * Crée une nouvelle instance du mail.
     */
    public function __construct($subjectText, $messageText, Reservation $reservation, $attachmentPath = null)
    {
        $this->subjectText = $subjectText;
        $this->messageText = $messageText;
        $this->reservation = $reservation;
        $this->attachmentPath = $attachmentPath; // 🔥 AJOUT
    }

    /**
     * Construction du message email.
     */
    public function build()
    {
        $email = $this->subject($this->subjectText)
            ->view('emails.reservation-notification')
            ->with([
                'messageText' => $this->messageText,
                'reservation' => $this->reservation,
            ]);

        // 🔥 Si une facture a été envoyée → attacher
        if ($this->attachmentPath) {
            $email->attach($this->attachmentPath, [
                'as' => 'facture.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
