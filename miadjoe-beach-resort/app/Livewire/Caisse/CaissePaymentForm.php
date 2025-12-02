<?php

namespace App\Livewire\Caisse;

use Livewire\Component;
use App\Models\Sale;
use App\Models\DiversServiceVente;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\CashAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CaissePaymentForm extends Component
{
    public ?int $venteId = null;
    public ?string $venteType = null; // 'service', 'resto', 'reservation'
    public $model = null; // Objet de vente ou réservation
    public $invoice = null;

    public float $paymentAmount = 0;
    public string $paymentMode = 'Espèces';
    public bool $showModal = false;

    // optional fields for remise/offert
    public float $remisePercent = 0;
    public float $remiseAmount = 0;
    public bool $isRemise = false;
    public bool $isOffert = false;
    public string $motifRemise = '';

    protected $listeners = ['openCaissePaymentForm' => 'openModal'];

    public function mount($venteType = null, $venteId = null)
    {
        if ($venteType && $venteId) {
            $this->venteType = $venteType;
            $this->venteId = $venteId;
            $this->loadModelAndInvoice();
        }
    }

    public function openModal($payload = null)
    {
        \Log::info('openModal triggered', ['payload' => $payload]);

        if (!$payload) {
            return;
        }

        $this->venteType = $payload['type'] ?? null;
        $this->venteId   = $payload['id'] ?? null;

        if (!$this->venteType || !$this->venteId) {
            return;
        }

        $this->loadModelAndInvoice();

        // propose par défaut le reste à payer en utilisant montant_final si présent
        $montantFinal = $this->invoice->montant_final ?? $this->invoice->montant_total ?? 0;
        $this->paymentAmount = max(0, $montantFinal - ($this->invoice->montant_paye ?? 0));

        $this->showModal = true;
    }

    private function loadModelAndInvoice()
    {
        switch ($this->venteType) {
            case 'service':
                $this->model = DiversServiceVente::find($this->venteId);
                $this->invoice = Invoice::firstOrCreate(
                    ['divers_service_vente_id' => $this->model?->id],
                    [
                        'montant_total' => $this->model?->total ?? 0,
                        'montant_final' => $this->model?->total ?? 0,
                        'montant_paye' => 0,
                        'statut' => 'En attente',
                    ]
                );
                break;

            case 'resto':
                $this->model = Sale::with('reservation')->find($this->venteId);

                if ($this->model?->reservation_id) {
                    $reservation = $this->model->reservation;
                    $total = $reservation?->total ?? $this->model?->total ?? 0;

                    $this->invoice = Invoice::firstOrCreate(
                        ['reservation_id' => $this->model->reservation_id],
                        [
                            'montant_total' => $total,
                            'montant_final' => $total,
                            'montant_paye' => 0,
                            'statut' => 'En attente',
                        ]
                    );
                } else {
                    $this->invoice = Invoice::firstOrCreate(
                        ['sale_id' => $this->model?->id],
                        [
                            'montant_total' => $this->model?->total ?? 0,
                            'montant_final' => $this->model?->total ?? 0,
                            'montant_paye' => 0,
                            'statut' => 'En attente',
                        ]
                    );
                }
                break;

            case 'reservation':
                $this->model = Reservation::with('invoice')->find($this->venteId);
                $this->invoice = $this->model?->invoice ?? Invoice::create([
                    'reservation_id' => $this->model?->id,
                    'montant_total' => $this->model?->total ?? 0,
                    'montant_final' => $this->model?->total ?? 0,
                    'montant_paye' => 0,
                    'statut' => 'En attente',
                ]);
                break;
        }

        if (!$this->model) {
            session()->flash('error', 'La vente ou réservation est introuvable.');
            $this->showModal = false;
        }
    }

    public function enregistrerPaiement()
    {
        if ($this->paymentAmount < 0) {
            session()->flash('error', 'Le montant doit être supérieur ou égal à 0.');
            return;
        }

        DB::beginTransaction();

        try {
            // Detecte si mode = Offert
            $isOffert = strtolower($this->paymentMode) === 'offert' || $this->isOffert;

            // Détection de la caisse en fonction du type de vente
            if ($this->model instanceof Sale) {
                // Si une réservation est liée, on traite comme hébergement
                if ($this->model->reservation_id) {
                    $caisse = 'Hébergement';
                } else {
                    $caisse = 'Restaurant';
                }
            }
            elseif ($this->model instanceof Reservation) {
                $caisse = 'Hébergement';
            }
            elseif ($this->model instanceof DiversServiceVente) {
                // Pour les services, tu veux garder la logique rôle
                $roleCreateur = $this->model->user->roles->first()->name ?? null;

                $caisse = match ($roleCreateur) {
                    'Réception' => 'Hébergement',
                    'Restauration' => 'Restaurant',
                    default => 'Divers',
                };
            } 
            else {
                // Sécurité
                $caisse = 'Divers';
            }

            // Calculs: on enregistre le paiement (si Offert, montant = 0, on indique remise 100%)
            $paymentData = [
                'sale_id' => $this->model instanceof Sale && !$this->model->reservation_id ? $this->model->id : null,
                'reservation_id' => $this->model instanceof Reservation
                    ? $this->model->id
                    : ($this->model instanceof Sale && $this->model->reservation_id ? $this->model->reservation_id : null),
                'divers_service_vente_id' => $this->model instanceof DiversServiceVente ? $this->model->id : null,
                'transaction_id' => 'TX-' . now()->timestamp . '-' . mt_rand(100,999),
                'montant' => $isOffert ? 0 : $this->paymentAmount,
                'mode_paiement' => $this->paymentMode,
                'statut' => $isOffert ? 'Payé' : 'Payé',
                'user_id' => Auth::id(),
                // remise fields
                'is_remise' => $this->isRemise || $isOffert ? 1 : 0,
                'remise_percent' => $this->isRemise ? $this->remisePercent : ($isOffert ? 100 : 0),
                'remise_amount' => $this->isRemise ? $this->remiseAmount : ($isOffert ? ($this->invoice->montant_final ?? $this->invoice->montant_total ?? 0) : 0),
                'motif_remise' => $this->motifRemise ?? null,
                'est_offert' => $isOffert ? 1 : 0,
            ];

            Payment::create($paymentData);

            // Recalculer les totaux à partir des paiements enregistrés
            $query = Payment::query();

            if ($this->invoice->sale_id) {
                $query->where('sale_id', $this->invoice->sale_id);
            } elseif ($this->invoice->reservation_id) {
                $query->where('reservation_id', $this->invoice->reservation_id);
            } elseif ($this->invoice->divers_service_vente_id) {
                $query->where('divers_service_vente_id', $this->invoice->divers_service_vente_id);
            }

            $totalPaid = (float) $query->sum('montant');
            $totalRemise = (float) $query->sum('remise_amount');

            $montantFinal = max(0, ($this->invoice->montant_total ?? 0) - $totalRemise);

            // Determine statut
            if ($isOffert) {
                $invoiceStatut = 'Offerte';
            } else {
                $invoiceStatut = $totalPaid >= $montantFinal
                    ? 'Payée'
                    : ($totalPaid > 0 ? 'Partiellement payée' : 'En attente');
            }

            // update invoice
            $this->invoice->update([
                'montant_paye' => $totalPaid,
                'remise_amount' => $totalRemise,
                'montant_final' => $montantFinal,
                'statut' => $invoiceStatut,
            ]);

            // MAJ caisse si paiement réel (non-offert) et montant > 0
            if (!$isOffert && ($this->paymentAmount > 0)) {
                CashAccount::updateOrCreate(
                    ['type_caisse' => $caisse, 'nom_compte' => $this->paymentMode],
                    ['solde' => DB::raw("solde + " . floatval($this->paymentAmount))]
                );
            }

            // MAJ statut entités liées
            $this->updateInvoiceStatus(); // méthode conserve la logique pour sale/reservation/diversService

            DB::commit();

            session()->flash('message', 'Paiement enregistré avec succès !');
            $this->showModal = false;

            // dispatch events similaires à ton code d'origine
            $this->dispatch('paymentCompleted', type: $this->venteType, id: $this->venteId);
            $this->dispatch('refreshCaisse');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur CaissePaymentForm::enregistrerPaiement() : ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de l’enregistrement du paiement : ' . $e->getMessage());
        }
    }

    private function updateInvoiceStatus(): void
    {
        $totalPaid = $this->invoice->montant_paye ?? 0;
        $total = $this->invoice->montant_final ?? $this->invoice->montant_total ?? 0;

        $invoiceStatus = 'En attente';
        $reservationStatus = null;

        if ($total > 0) {
            $ratio = $totalPaid / $total;

            if ($ratio >= 1) {
                $invoiceStatus = 'Payée';
                $reservationStatus = 'Confirmée';
            } elseif ($ratio >= 0.5) {
                $invoiceStatus = 'Partiellement payée';
                $reservationStatus = 'Confirmée';
            } elseif ($totalPaid > 0) {
                $invoiceStatus = 'Partiellement payée';
            } else {
                $invoiceStatus = 'En attente';
            }
        } else {
            // montant final = 0 => offerte ou intégralement remise
            $invoiceStatus = 'Offerte';
            $reservationStatus = 'Confirmée';
        }

        $this->invoice->update(['statut' => $invoiceStatus]);

        if ($this->invoice->reservation_id && $reservationStatus) {
            Reservation::where('id', $this->invoice->reservation_id)
                ->update(['statut' => $reservationStatus]);
        }

        if ($this->invoice->sale_id) {
            Sale::where('id', $this->invoice->sale_id)->update(['statut' => $invoiceStatus === 'Payée' ? 'Payé' : $invoiceStatus]);
        }

        if ($this->invoice->divers_service_vente_id) {
            DiversServiceVente::where('id', $this->invoice->divers_service_vente_id)->update(['statut' => $invoiceStatus === 'Payée' ? 'Payé' : $invoiceStatus]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('refreshCaisse');
    }

    public function render()
    {
        return view('livewire.caisse.caisse-payment-form', [
            'model' => $this->model,
            'invoice' => $this->invoice,
        ]);
    }
}
