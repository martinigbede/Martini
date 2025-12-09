<?php

namespace App\Livewire\Comptabilite;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HorsVente;
use App\Models\CashAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HorsVenteModale extends Component
{
    use WithPagination;

    public $montant;
    public $mode_paiement = 'Espèces';
    public $motif;

    public $showModal = false;

    public $startDate;
    public $endDate;

    protected $listeners = [
        'open-hors-vente-modal' => 'openModal',
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->reset(['montant', 'mode_paiement', 'motif']);
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required',
        ]);

        DB::transaction(function () {

            // 1. Enregistrement hors vente
            $entry = HorsVente::create([
                'montant'       => $this->montant,
                'mode_paiement' => $this->mode_paiement,
                'motif'         => $this->motif,
                'user_id'       => Auth::id(),
            ]);

            // 2. Récupération ou création du compte caisse
            $caisse = CashAccount::firstOrCreate(
                [
                    'type_caisse' => 'Restaurant',
                    'nom_compte'  => $this->mode_paiement,
                ],
                ['solde' => 0]
            );

            // 3. Ajout d'une transaction standardisée
            $caisse->addTransaction(
                $this->montant,
                'entree',
                "Apport hors vente #{$entry->id} : {$this->motif}",
                Auth::id()
            );
        });

        session()->flash('success', 'Apport hors vente enregistré avec succès.');
        $this->showModal = false;

        $this->dispatch('refresh-data');
    }

    public function getEntriesProperty()
    {
        return HorsVente::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.comptabilite.hors-vente-modale', [
            'entries' => $this->entries,
        ]);
    }
}
