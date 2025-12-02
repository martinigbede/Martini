<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DiversServiceVente;

class VenteServiceComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected $listeners = [
        'venteSaved' => '$refresh',
        'openPaiementDiversService' => 'loadVente'
    ];

    // 🔐 Pour suppression sécurisée
    public bool $showDeleteModal = false;
    public ?int $deleteVenteId = null;
    public string $deletePassword = '';
    public ?string $errorDeletePassword = null;

    public bool $showModal = false;
    public ?int $venteId = null;

    public function openVenteModalProxy()
    {
        // on renvoie l’event front-end EXACTEMENT comme avant
        $this->dispatch('openVenteFormModal');
    }

    public function loadVente($venteId)
    {
        $this->venteId = $venteId;
        $this->vente = DiversServiceVente::findOrFail($venteId);
        $this->showModal = true;
    }

    /** ------------------------------
     * Ouvrir le modal de suppression
     * ------------------------------ */
    public function confirmDeleteVente($id)
    {
        $this->deleteVenteId = $id;
        $this->deletePassword = '';
        $this->errorDeletePassword = null;
        $this->showDeleteModal = true;
    }

    /** ------------------------------
     * Suppression sécurisée avec mot de passe
     * ------------------------------ */
    public function deleteVenteSecure()
    {
        $settingPassword = \App\Models\Setting::getValue('delete_password');

        if (!$settingPassword || $this->deletePassword !== $settingPassword) {
            $this->errorDeletePassword = "Mot de passe incorrect.";
            return;
        }

        $vente = DiversServiceVente::findOrFail($this->deleteVenteId);

        // Suppression des items
        $vente->items()->delete();
        $vente->delete();

        $this->showDeleteModal = false;
        session()->flash('message', 'Vente supprimée avec succès !');

        $this->resetPage();
        $this->dispatch('venteSaved');
    }

    public function editVente($venteId)
    {
        $this->dispatch('modifierVenteForm', venteId: $venteId);
    }

    public function payerService($venteId)
    {
        $this->dispatch('openDiversPaymentModal', venteId: $venteId);
    }

    public function openDetailModal($venteId)
    {
        $this->dispatch('openDetailModal', venteId: $venteId);
    }

    /** ------------------------------
     * Rendu
     * ------------------------------ */
    public function render()
    {
        // Récupère le rôle de l’utilisateur connecté
        $role = auth()->user()->roles->first()?->name;

        // Filtre toutes les ventes créées par des users ayant CE rôle
        $ventes = DiversServiceVente::with(['items.service'])
            ->whereHas('user.roles', function ($q) use ($role) {
                $q->where('name', $role);
            })
            ->latest()
            ->paginate(5);

        return view('livewire.vente-service-component', compact('ventes'));
    }

}
