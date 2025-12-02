<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DiversService;
use App\Models\DiversServiceVente;
use App\Models\DiversServiceVenteItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class VenteServiceForm extends Component
{
    public $client_nom;
    public $type_client = 'individuel';
    public $remarque;
    public $lignes = [];
    public $total = 0;
    public $showModal = false;
    public $venteId = null;

    protected $listeners = [
        'openVenteFormModal' => 'ouvrirModal',
        'modifierVenteForm'  => 'modifierVenteForm'
    ];

    public function mount()
    {
        $this->ajouterLigne();
    }

    public function ouvrirModal()
    {
        $this->showModal = true;
    }

    public function ajouterLigne()
    {
        $this->lignes[] = [
            'service_id' => '',
            'mode_facturation' => 'fixe',
            'quantite' => 1,
            'duree' => null,
            'prix_unitaire' => 0,
            'sous_total' => 0,
        ];
    }

    public function supprimerLigne($index)
    {
        unset($this->lignes[$index]);
        $this->lignes = array_values($this->lignes);
        $this->calculerTotal();
    }

    public function updatedLignes()
    {
        $this->calculerTotal();
    }

    public function calculerTotal()
    {
        $this->total = 0;

        foreach ($this->lignes as $index => $ligne) {
            $service = DiversService::find($ligne['service_id']);

            if ($service) {
                $prix = $service->prix;
                $quantite = $ligne['quantite'] ?? 1;

                $ligne['prix_unitaire'] = $prix;
                $ligne['sous_total'] =
                    ($ligne['mode_facturation'] === 'duree' && $ligne['duree'])
                        ? $prix * $ligne['duree']
                        : $prix * $quantite;

                $this->lignes[$index] = $ligne;
                $this->total += $ligne['sous_total'];
            }
        }
    }

    public function validerVente()
    {
        $this->validate([
            'client_nom' => 'nullable|string|max:255',
            'type_client' => 'required|in:individuel,groupe',
            'lignes.*.service_id' => 'required|exists:divers_services,id',
        ]);

        DB::transaction(function () {

            if ($this->venteId) {

                $vente = DiversServiceVente::findOrFail($this->venteId);

                $vente->update([
                    'client_nom' => $this->client_nom,
                    'type_client' => $this->type_client,
                    'total' => $this->total,
                    'remarque' => $this->remarque,
                ]);

                $vente->items()->delete();
                $this->enregistrerItems($vente->id);

                session()->flash('message', 'Vente mise à jour avec succès !');

            } else {

                $vente = DiversServiceVente::create([
                    'client_nom' => $this->client_nom,
                    'type_client' => $this->type_client,
                    'user_id' => Auth::id(),
                    'total' => $this->total,
                    'remarque' => $this->remarque,
                ]);

                $this->enregistrerItems($vente->id);

                Invoice::create([
                    'sale_id' => null,
                    'reservation_id' => null,
                    'divers_service_vente_id' => $vente->id,
                    'montant_total' => $vente->total,
                    'montant_final' => $vente->total,
                    'montant_paye' => 0,
                    'remise_amount' => 0,
                    'statut' => 'en_attente'
                ]);

                session()->flash('message', 'Vente enregistrée avec succès !');
            }
        });

        $this->fermerModal();
        $this->dispatch('venteSaved');
    }

    private function enregistrerItems($venteId)
    {
        foreach ($this->lignes as $ligne) {
            if (!$ligne['service_id']) continue;

            DiversServiceVenteItem::create([
                'divers_service_vente_id' => $venteId,
                'divers_service_id' => $ligne['service_id'],
                'mode_facturation' => $ligne['mode_facturation'],
                'quantite' => $ligne['quantite'],
                'duree' => $ligne['duree'],
                'prix_unitaire' => $ligne['prix_unitaire'],
                'sous_total' => $ligne['sous_total'],
            ]);
        }
    }

    /**
     * -------------------------
     *   Edition d’une vente
     * -------------------------
     */
    public function modifierVenteForm($venteId)
    {
        $vente = DiversServiceVente::with('items')->findOrFail($venteId);

        $this->venteId = $vente->id;
        $this->client_nom = $vente->client_nom;
        $this->type_client = $vente->type_client;
        $this->remarque = $vente->remarque;
        $this->total = $vente->total;

        // reconstruit les lignes
        $this->lignes = [];
        foreach ($vente->items as $item) {
            $this->lignes[] = [
                'service_id' => $item->divers_service_id,
                'mode_facturation' => $item->mode_facturation,
                'quantite' => $item->quantite,
                'duree' => $item->duree,
                'prix_unitaire' => $item->prix_unitaire,
                'sous_total' => $item->sous_total,
            ];
        }

        $this->showModal = true;
    }

    public function fermerModal()
    {
        $this->reset(['client_nom', 'type_client', 'remarque', 'lignes', 'total', 'showModal', 'venteId']);
        $this->ajouterLigne();
    }

    public function openVenteModalProxy()
    {
        $this->dispatch('openVenteFormModal');
    }

    public function render()
    {
        $services = DiversService::where('disponible', true)->get();

        return view('livewire.vente-service-form', compact('services'));
    }
}