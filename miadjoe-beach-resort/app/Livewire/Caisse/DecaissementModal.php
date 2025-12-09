<?php

namespace App\Livewire\Caisse;

use Livewire\Component;
use App\Models\CashAccount;
use App\Models\Disbursement;
use Illuminate\Support\Facades\Auth;

class DecaissementModal extends Component
{
    public $show = false;

    // Caisse fixée directement ici
    public $typeCaisse = 'Hébergement';

    public $montant;
    public $motif;
    public $mode = 'Espèces';

    protected $rules = [
        'montant' => 'required|numeric|min:1',
        'motif' => 'required|string|max:255',
        'mode'   => 'required|string',
    ];

    protected $listeners = ['ouvrir-decaissement' => 'ouvrir'];

    public function ouvrir()
    {
        $this->resetValidation();
        $this->reset(['montant', 'motif', 'mode']);
        $this->show = true;
    }

    public function decaisser()
    {
        $this->validate();

        // Map mode -> comptes associés
        $mapCompte = [
            'Espèces'      => ['Espèces'],
            'Mobile Money' => ['Mobile Money'],
            'Flooz'        => ['Flooz'],
            'Mix by Yas'   => ['Mix by Yas'],
        ];

        if (!isset($mapCompte[$this->mode])) {
            session()->flash('error', "Mode de paiement inconnu.");
            return;
        }

        // Récupération du compte
        $compte = CashAccount::where('type_caisse', $this->typeCaisse)
            ->whereIn('nom_compte', $mapCompte[$this->mode])
            ->first();

        if (!$compte) {
            session()->flash('error', "Compte introuvable pour la caisse {$this->typeCaisse}.");
            return;
        }

        if ($compte->solde < $this->montant) {
            session()->flash('error', "Solde insuffisant dans le compte {$compte->nom_compte}.");
            return;
        }

        // Mise à jour du solde
        $compte->addTransaction(
            amount: $this->montant,
            type: 'sortie',
            description: "Décaissement : {$this->motif}",
            userId: Auth::id()
        );

        // Création du décaissement
        Disbursement::create([
            'reservation_id'   => null,
            'montant'          => $this->montant,
            'motif'            => $this->motif,
            'user_id'          => Auth::id(),
            'cash_account_id'  => $compte->id,
            'caisse_source_id' => $compte->id,
            'est_encaisse'     => 0,
            'encaisse_user_id' => null,
            'encaisse_at'      => null,
        ]);

        session()->flash('success', "Décaissement effectué avec succès.");

        // Fermer le modal + rafraîchir les données parent
        $this->show = false;
        $this->dispatch('refresh-data');
        $this->dispatch('decaissementEffectue'); 
        $this->dispatch('flashMessage', ['message' => 'Décaissement encaissé avec succès !', 'type' => 'success']);  
    }

    public function render()
    {
        return view('livewire.caisse.decaissement-modal');
    }
}
