<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DiversServiceVente;
use App\Models\Payment;
use App\Models\CashAccount;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiversServicePaymentModal extends Component
{
    public $showModal = false;

    public $venteId;
    public $vente;
    public $invoice;

    public $montantPaye = 0;
    public $modePaiement = 'Espèces';

    public $total;
    public $alreadyPaid;
    public $remaining;

    // 🔹 Ajout remise
    public $remisePercent = 0;
    public $remiseAmount = 0;

    protected $listeners = [
        'openDiversPaymentModal' => 'loadVente'
    ];

    public function updatedRemisePercent()
    {
        $this->remisePercent = floatval($this->remisePercent);
        $this->remiseAmount = ($this->total * $this->remisePercent) / 100;
        $this->recalculateRemaining();
    }

    public function updatedRemiseAmount()
    {
        $this->remiseAmount = floatval($this->remiseAmount);
        $this->remisePercent = $this->total > 0 ? ($this->remiseAmount / $this->total) * 100 : 0;
        $this->recalculateRemaining();
    }

    private function recalculateRemaining()
    {
        $finalTotal = $this->total - $this->remiseAmount;
        $this->remaining = max(0, $finalTotal - $this->alreadyPaid);
        $this->montantPaye = $this->remaining;
    }

    public function loadVente($venteId)
    {
        $this->venteId = $venteId;
        $this->vente = DiversServiceVente::with('payments')->findOrFail($venteId);

        $this->invoice = Invoice::firstOrCreate(
            ['divers_service_vente_id' => $venteId],
            [
                'sale_id' => null,
                'reservation_id' => null,
                'montant_total' => $this->vente->total,
                'montant_final' => $this->vente->total,
                'montant_paye' => 0,
                'statut' => 'En attente'
            ]
        );

        $this->total = $this->invoice->montant_final ?? $this->invoice->montant_total ?? $this->vente->total;

        $this->alreadyPaid = Payment::where('divers_service_vente_id', $venteId)->sum('montant');

        $this->remaining = max(0, $this->total - $this->alreadyPaid);

        $this->montantPaye = $this->remaining;

        $this->showModal = true;
    }

    public function savePayment()
    {
        try {
            DB::transaction(function () {

                // Déterminer la caisse selon le rôle du créateur
                $roleCreateur = $this->vente->user->roles->first()->name ?? null;

                $caisse = match ($roleCreateur) {
                    'Réception' => 'Hébergement',
                    'Restauration' => 'Restaurant',
                    default => 'Divers',
                };

                // 🔹 Enregistrer le paiement avec remise
                Payment::create([
                    'montant' => $this->montantPaye,
                    'mode_paiement' => $this->modePaiement,
                    'statut' => 'Payé',
                    'divers_service_vente_id' => $this->venteId,
                    'user_id' => Auth::id(),
                    'remise_percent' => $this->remisePercent,
                    'remise_amount' => $this->remiseAmount,
                ]);

                // 🔹 Mise à jour facture
                $totalPaid = Payment::where('divers_service_vente_id', $this->venteId)->sum('montant');
                $totalRemise = Payment::where('divers_service_vente_id', $this->venteId)->sum('remise_amount');

                $montantFinal = ($this->invoice->montant_total - $totalRemise);

                $statut = $totalPaid >= $montantFinal
                    ? 'Payée'
                    : ($totalPaid > 0 ? 'Partiellement payée' : 'Non payée');

                $this->invoice->update([
                    'montant_paye' => $totalPaid,
                    'statut' => $statut,
                    'remise_amount' => $totalRemise,
                    'montant_final' => $montantFinal,
                ]);

                // 🔹 Mettre la vente en statut Payée si 100%
                if ($totalPaid >= $montantFinal) {
                    $this->vente->update(['statut' => 'Payé']);
                }

                    // 🔹 Mise à jour caisse
                    $compte = CashAccount::firstOrCreate(
                    [
                        'type_caisse' => $caisse,
                        'nom_compte'  => $this->modePaiement,
                    ],
                    [
                        'solde' => 0
                    ]
                );

                $compte->addTransaction(
                    amount: $this->montantPaye,
                    type: 'entree',
                    description: "Paiement Divers Service Vente #{$this->venteId}",
                    userId: Auth::id(),
                );
            });

            session()->flash('success', 'Paiement enregistré avec succès !');

            $this->dispatch('paymentSaved');
            $this->showModal = false;

        } catch (\Throwable $e) {
            Log::error('Erreur paiement divers service: '.$e->getMessage());
            session()->flash('error', 'Erreur: '.$e->getMessage());
        }
    }

    public function fermer()
    {
        $this->showModal = false;
    }

    public function payer()
    {
        $this->savePayment();
    }

    public function render()
    {
        return view('livewire.divers-service-payment-modal');
    }
}