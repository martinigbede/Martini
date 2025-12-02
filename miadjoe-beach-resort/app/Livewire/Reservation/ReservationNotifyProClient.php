<?php

namespace App\Livewire\Reservation;

use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Mail\ReservationNotificationMail;

class ReservationNotifyProClient extends Component
{
    use WithFileUploads;

    public $reservationId;
    public $reservation;
    public $clientEmail;
    public $clientName;

    public $subject = "Confirmation de votre réservation";
    public $messageContent = "Bonjour, votre réservation a bien été enregistrée.";

    public $template = 'confirmation'; // confirmation | facture | rappel
    public $attachment; // PDF importé depuis PC / mobile
    public $attachmentPath; // Chemin temporaire du fichier PDF
    public $attachmentFile;

    public $isSending = false;

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;

        // Charger la réservation avec le client
        $this->reservation = Reservation::with('client')->findOrFail($reservationId);

        // Pré-remplir email et nom du client
        $this->clientEmail = $this->reservation->client->email ?? '';
        $this->clientName = $this->reservation->client->nom . ' ' . $this->reservation->client->prenom;
    }

    public function sendNotification()
    {
        $this->validate([
            'clientEmail' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'messageContent' => 'required|string|min:5',
            'attachment' => 'nullable|mimes:pdf|max:5120',
        ]);

        $this->isSending = true;

        try {
            $attachmentPath = null;

            if ($this->attachment) {
                // Stocker le PDF dans storage/app/public/factures
                $path = $this->attachment->store('factures', 'public');
                // Chemin absolu pour le Mailable
                $attachmentPath = Storage::disk('public')->path($path);
            }

            Mail::to($this->clientEmail)->send(
                new ReservationNotificationMail(
                    $this->subject,
                    $this->messageContent,
                    $this->reservation,
                    $attachmentPath
                )
            );

            session()->flash('message', 'Notification envoyée avec succès à ' . $this->clientEmail);
            $this->dispatch('closeNotifyModal');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur : ' . $e->getMessage());
        } finally {
            $this->isSending = false;
        }
    }

    public function closeModal()
    {
        $this->dispatch('closeNotifyModal');
    }

    public function render()
    {
        return view('livewire.reservation.reservation-notify-pro-client');
    }
}
