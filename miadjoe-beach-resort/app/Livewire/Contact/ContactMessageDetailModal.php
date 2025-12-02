<?php

namespace App\Livewire\Contact;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\Attributes\On;

class ContactMessageDetailModal extends Component
{
    public $isOpen = false;
    public $message;
    public $newStatus; // Pour le champ de statut dans la modale

    // Écoute l'événement 'showDetails' émis par le composant d'Inbox
    #[On('showMessageDetails')] // Nous utiliserons cet événement pour l'ouverture
    public function show($messageId)
    {
        $this->message = ContactMessage::findOrFail($messageId);
        $this->newStatus = $this->message->reponse_statut; // Initialise avec le statut actuel
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->message = null;
    }
    
    public function updateStatus()
    {
        if ($this->message) {
            $this->message->reponse_statut = $this->newStatus;
            $this->message->save();
            session()->flash('message', 'Statut du message mis à jour à "' . $this->newStatus . '".');
            $this->dispatch('refreshList'); // Notifie l'Inbox de rafraîchir
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.contact.contact-message-detail-modal');
    }
}