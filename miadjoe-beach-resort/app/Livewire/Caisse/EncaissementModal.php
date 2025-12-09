<?php

namespace App\Livewire\Caisse;

use Livewire\Component;
use App\Models\CashAccount;
use App\Models\Disbursement;
use Illuminate\Support\Facades\Auth;

class EncaissementModal extends Component
{
    public $show = false;
    public $caisseId;

    public $caisses;
    public $decaissementsNonEncaisse;

    protected $rules = [
        'caisseId' => 'required|exists:cash_accounts,id',
    ];

    protected $listeners = ['ouvrir-encaissement' => 'ouvrir'];

    public function ouvrir()
    {
        $this->resetValidation();
        $this->reset(['caisseId']);

        // Charger toutes les caisses Restaurant
        $this->caisses = CashAccount::where('type_caisse', 'Restaurant')->get();

        // Charger tous les décaissements non encaissés
        $this->decaissementsNonEncaisse = Disbursement::where('est_encaisse', false)->get();

        $this->show = true;
    }

    public function encaisserUn($id)
    {
        $this->validate();

        $dec = Disbursement::findOrFail($id);
        $caisse = CashAccount::findOrFail($this->caisseId);

        // Ajouter au solde de la caisse
        $caisse->addTransaction(
            amount: $dec->montant,
            type: 'entree',
            description: "Encaissement décaissement #{$dec->id} : {$dec->motif}",
            userId: Auth::id()
        );

        // Marquer comme encaissé
        $dec->update([
            'est_encaisse' => true,
            'encaisse_user_id' => Auth::id(),
            'cash_account_id' => $this->caisseId,
            'encaisse_at' => now(),
        ]);

        // Rafraîchir la liste
        $this->decaissementsNonEncaisse = Disbursement::where('est_encaisse', false)->get();
        // Notifier le parent
        $this->dispatch('refresh-data');
        $this->dispatch('encaissementEffectue');
    }

    public function encaisserTout()
    {
        $this->validate();

        $caisse = CashAccount::findOrFail($this->caisseId);

        foreach ($this->decaissementsNonEncaisse as $dec) {
            // Créditer la caisse
            $caisse->addTransaction(
                amount: $dec->montant,
                type: 'entree',
                description: "Encaissement décaissement #{$dec->id} : {$dec->motif}",
                userId: Auth::id()
            );

            // Marquer le décaissement comme encaissé
            $dec->update([
                'est_encaisse' => true,
                'encaisse_user_id' => Auth::id(),
                'cash_account_id' => $this->caisseId,
                'encaisse_at' => now(),
            ]);
        }

        // Fermer
        $this->show = false;

        // Notifier le parent
        $this->dispatch('refresh-data');
        $this->dispatch('encaissementEffectue');
        $this->dispatch('flashMessage', ['message' => 'Décaissement encaissé avec succès !', 'type' => 'success']); 
    }

    public function render()
    {
        return view('livewire.caisse.encaissement-modal');
    }
}
