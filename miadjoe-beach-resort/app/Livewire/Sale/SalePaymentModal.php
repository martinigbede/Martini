<?php

namespace App\Livewire\Sale;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\CashAccount;
use App\Models\Disbursement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalePaymentModal extends Component
{
    public $showModal = false;

    public $saleId;
    public $sale;
    public $invoice;

    public $montantPaye = 0;
    public $modePaiement = 'Espèces';
    public $remise = 0;
    public $motifRemise;

    public $totalInvoice = 0;
    public $alreadyPaid = 0;
    public $remaining = 0;

    public $isLinkedToReservation = false;
    public $pendingDecaissements = [];
    public $montantAEncaisser = 0;

    protected $listeners = ['openPaymentModal' => 'loadSale'];


    public function refreshData()
    {
        $this->sales = Sale::with('invoice', 'reservation')->get();
    }

    public function loadSale($saleId)
    {
        $this->resetPaymentFields();

        $this->saleId = $saleId;
        $this->sale = Sale::with('reservation')->findOrFail($saleId);

        // Vérifie si vente liée à réservation
        $this->isLinkedToReservation = $this->sale->reservation_id !== null;

        // Récupère ou crée la facture
        $this->invoice = Invoice::firstOrCreate(
            ['sale_id' => $saleId],
            [
                'montant_total' => $this->sale->total,
                'montant_final' => $this->sale->total,
                'montant_paye' => 0,
                'statut' => 'En attente',
            ]
        );

        $this->invoice->refresh();

        // Calcul normal pour une vente libre
        $this->totalInvoice = $this->invoice->montant_total;
        $this->alreadyPaid = $this->invoice->payments()->sum('montant');
        $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);

        // CAS : VENTE LIÉE À RÉSERVATION
        if ($this->isLinkedToReservation) {
            $reservationId = $this->sale->reservation_id;

            $decaissements = Disbursement::where('reservation_id', $reservationId)
                ->where('est_encaisse', false)
                ->orderBy('created_at', 'asc')
                ->get();

            $this->pendingDecaissements = $decaissements;
            $this->montantAEncaisser = (float) $decaissements->sum('montant');

            // affichage automatique
            $this->montantPaye = $this->montantAEncaisser;
        } else {
            // vente libre
            $this->montantPaye = $this->remaining;
        }

        $this->showModal = true;
    }

    public function resetPaymentFields()
    {
        $this->montantPaye = 0;
        $this->modePaiement = 'Espèces';
        $this->remise = 0;
        $this->motifRemise = null;
        $this->pendingDecaissements = [];
        $this->montantAEncaisser = 0;
        $this->isLinkedToReservation = false;
    }

    public function savePayment()
    {
        try {

            // ------------------------------------------------------
            // CAS 1 : VENTE LIÉE À RÉSERVATION → ENCAISSEMENT SIMPLE
            // ------------------------------------------------------
            if ($this->isLinkedToReservation) {

                if ($this->montantAEncaisser <= 0) {
                    session()->flash('error', "Aucun décaissement non encaissé trouvé.");
                    return;
                }

                $finalAmount = $this->montantAEncaisser;

                DB::transaction(function () use ($finalAmount) {

                    // AJOUT EN CAISSE
                    $compte = CashAccount::firstOrCreate(
                        [
                            'type_caisse' => 'Restaurant',
                            'nom_compte'  => $this->modePaiement,
                        ],
                        [
                            'solde' => 0
                        ]
                    );

                    $compte->addTransaction(
                        amount: $finalAmount,
                        type: 'entree',
                        description: "Encaissement décaissements réservation #{$this->sale->reservation_id}",
                        userId: Auth::id()
                    );

                    // MARQUER LES DÉCAISSEMENTS ENCAISSÉS
                    $reservationId = $this->sale->reservation_id;
                    $now = now();

                    Disbursement::where('reservation_id', $reservationId)
                        ->where('est_encaisse', false)
                        ->update([
                            'est_encaisse' => true,
                            'encaisse_user_id' => Auth::id(),
                            'encaisse_at' => $now,
                            'updated_at' => $now,
                        ]);
                });

                session()->flash('success', 'Encaissement réalisé avec succès.');
                $this->dispatch('paymentSaved');
                $this->showModal = false;
                return;
            }

            // ------------------------------------------------------
            // CAS 2 : VENTE LIBRE → LOGIQUE NORMALE
            // ------------------------------------------------------
            if ($this->modePaiement === 'Offert') {
                $this->remise = $this->remaining;
                $this->montantPaye = 0;
            }

            $finalAmount = max(0, $this->montantPaye - $this->remise);

            Payment::create([
                'sale_id'         => $this->saleId ?? null,
                'reservation_id'  => $this->invoice->reservation_id ?? null,
                'montant'         => $finalAmount,
                'mode_paiement'   => $this->modePaiement,
                'remise_amount'   => $this->remise,
                'motif_remise'    => $this->motifRemise,
                'date_paiement'   => now(),
                'user_id'         => Auth::id(),
                'statut'          => 'Payé',
            ]);

            // RECALCUL FACTURE
            $totalPaid = $this->invoice->payments()->sum('montant');
            $totalRemise = $this->invoice->payments()->sum('remise_amount');
            $montantFinal = max(0, $this->invoice->montant_total - $totalRemise);

            $statut = $totalPaid >= $montantFinal
                ? 'Payée'
                : ($totalPaid > 0 ? 'Partiellement payée' : 'En attente');

            if ($this->modePaiement === 'Offert') {
                $statut = 'Offerte';
            }

            $this->invoice->update([
                'montant_paye' => $totalPaid,
                'remise_amount' => $totalRemise,
                'montant_final' => $montantFinal,
                'statut' => $statut,
            ]);

            // MAJ CAISSE (VENTE LIBRE)
            if ($finalAmount > 0 && $this->modePaiement !== 'Offert') {

                $compte = CashAccount::firstOrCreate(
                    [
                        'type_caisse' => 'Restaurant',
                        'nom_compte'  => $this->modePaiement,
                    ],
                    [
                        'solde' => 0
                    ]
                );

                $compte->addTransaction(
                    amount: $finalAmount,
                    type: 'entree',
                    description: "Paiement vente libre #{$this->saleId}",
                    userId: Auth::id()
                );
            }

            $this->dispatch('paymentSaved');
            $this->showModal = false;

        } catch (\Throwable $e) {
            Log::error('Erreur SalePaymentModal::savePayment() : '.$e->getMessage());
            session()->flash('error', 'Erreur : '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.sale.sale-payment-modal');
    }
}
