<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Payment;

class SemoaPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public Payment $payment;
    public array $semoaData;

    public function __construct(Reservation $reservation, Payment $payment, array $semoaData)
    {
        $this->reservation = $reservation;
        $this->payment = $payment;
        $this->semoaData = $semoaData;
    }

    public function build()
    {
        return $this->subject('Notification paiement SEMOA(CashPay)')
            ->markdown('emails.semoa.notification');
    }
}
