<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DiversService;
use Illuminate\Support\Facades\Auth;

class DiversServiceComponent extends Component
{
    public $services;
    public $nom;
    public $description;
    public $prix;
    public $disponible = true;
    public $serviceId = null;
    public $showModal = false;

    protected $rules = [
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'prix' => 'required|numeric|min:0',
        'disponible' => 'boolean',
    ];

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = DiversService::all();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        $this->serviceId = $id;

        if ($id) {
            $service = DiversService::findOrFail($id);
            $this->nom = $service->nom;
            $this->description = $service->description;
            $this->prix = $service->prix;
            $this->disponible = $service->disponible;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->nom = '';
        $this->description = '';
        $this->prix = '';
        $this->disponible = true;
    }

    public function saveService()
    {
        $this->authorizeAccess();

        $this->validate();

        DiversService::updateOrCreate(
            ['id' => $this->serviceId],
            [
                'nom' => $this->nom,
                'description' => $this->description,
                'prix' => $this->prix,
                'disponible' => $this->disponible,
            ]
        );

        session()->flash('message', 'Service sauvegardé avec succès.');

        $this->closeModal();
        $this->resetForm();
        $this->loadServices();
    }

    public function deleteService($id)
    {
        $this->authorizeAccess();

        DiversService::findOrFail($id)->delete();
        session()->flash('message', 'Service supprimé.');
        $this->loadServices();
    }

    protected function authorizeAccess()
    {
        $userRole = Auth::user()->role;
        if ($userRole === 'Comptable') {
            abort(403, 'Accès refusé.');
        }
    }

    public function render()
    {
        return view('livewire.divers-service-component');
    }
}
