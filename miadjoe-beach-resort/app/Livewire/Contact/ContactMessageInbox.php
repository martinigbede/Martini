<?php

namespace App\Livewire\Contact;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactMessageInbox extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $perPage = 15;
    
    // Pour afficher les détails
    public $selectedMessageId = null;
    public $isDetailModalOpen = false;

    protected $listeners = ['refreshList' => '$refresh'];

    public function render()
    {
        $query = ContactMessage::query();

        if ($this->search) {
            $query->where('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('sujet', 'like', '%' . $this->search . '%');
        }
        
        if ($this->statusFilter) {
            $query->where('reponse_statut', $this->statusFilter);
        }

        $messages = $query->latest()->paginate($this->perPage);

        return view('livewire.contact.contact-message-inbox', [
            'messages' => $messages,
        ]);
    }

    public function viewDetails($messageId)
    {
        $this->selectedMessageId = $messageId;
        $this->isDetailModalOpen = true;
        // Émet vers le nouveau composant
        $this->dispatch('showMessageDetails', id: $messageId)->to('admin.contact-message-detail-modal'); 
    }

    public function closeDetailsModal()
    {
        $this->isDetailModalId = null;
        $this->isDetailModalOpen = false;
    }
    
    public function markAs($status)
    {
        if ($this->selectedMessageId) {
            $message = ContactMessage::findOrFail($this->selectedMessageId);
            $message->reponse_statut = $status;
            $message->save();
            session()->flash('message', "Statut du message mis à jour à '{$status}'.");
            $this->dispatch('refreshList');
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
        $this->dispatchSelf('refresh');
    }
}