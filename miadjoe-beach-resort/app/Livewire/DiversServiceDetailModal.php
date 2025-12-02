<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DiversServiceVente;
use App\Models\Invoice;

class DiversServiceDetailModal extends Component
{
    public $showModal = false;
    public $venteId;
    public $vente;
    public $invoice;

    protected $listeners = [
        'openDetailModal' => 'loadDetails'
    ];

    public function loadDetails($venteId)
    {
        $this->venteId = $venteId;

        // Chargement complet de la vente
        $this->vente = DiversServiceVente::with(['items.service', 'payments', 'user.roles'])
            ->findOrFail($venteId);

        // Charger la facture associée
        $this->invoice = Invoice::where('divers_service_vente_id', $venteId)->first();

        $this->showModal = true;
    }

    public function fermer()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.divers-service-detail-modal');
    }
}
