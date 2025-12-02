<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class SaleCalculationService
{
    /**
     * Calcule le total d'une vente selon le menu, la quantité et l'unité.
     */
    public function calculateTotal(int $menuId, int $quantite, ?string $unite = null): array
    {
        $menu = Menu::findOrFail($menuId);

        if ($menu->a_unites && $menu->unites) {
            $unites = json_decode($menu->unites, true);
            $prixUnitaire = $unites[$unite] ?? $menu->prix;
        } else {
            $prixUnitaire = $menu->prix;
        }

        $total = round($quantite * $prixUnitaire, 2);

        return [
            'prix_unitaire' => $prixUnitaire,
            'total' => $total,
        ];
    }

    /**
     * Met à jour ou crée la facture et le paiement liés à la réservation ou à la vente.
     */
    public function updateInvoiceAndPayment(
        ?Reservation $reservation,
        ?Sale $sale,
        float $montantVente,
        ?float $montantPaye = null,
        string $modePaiement = 'Espèces'
        ): void {
        DB::transaction(function () use ($reservation, $sale, $montantVente, $montantPaye, $modePaiement) {

            // 🔹 Cas avec réservation
            if ($reservation) {
                $invoice = Invoice::firstOrNew(['reservation_id' => $reservation->id]);
                $invoice->sale_id = $sale?->id;
                $invoice->montant_total = $montantVente;
                $invoice->montant_paye = $montantPaye ?? 0;

                // Statut de la facture
                if ($invoice->montant_paye >= $invoice->montant_total) {
                    $invoice->statut = 'Payée';
                } elseif ($invoice->montant_paye > 0) {
                    $invoice->statut = 'Partielle';
                } else {
                    $invoice->statut = 'en_attente';
                }
                $invoice->save();

                // Paiement
                if ($montantPaye && $montantPaye > 0 && $sale) {
                    Payment::updateOrCreate(
                        ['sale_id' => $sale->id],
                        [
                            'reservation_id' => $reservation->id,
                            'invoice_id' => $invoice->id,
                            'montant' => $montantPaye,
                            'mode_paiement' => $modePaiement,
                            'statut' => 'Payée',
                            'date_paiement' => now(),
                        ]
                    );
                }

                // Statut réservation
                $reservation->update([
                    'statut' => ($invoice->montant_paye >= ($invoice->montant_total * 0.5)) ? 'Confirmée' : 'En attente'
                ]);
            }

            // 🔹 Cas sans réservation (vente directe)
            elseif ($sale) {
                $invoice = Invoice::firstOrNew(['sale_id' => $sale->id]);
                $invoice->montant_total = $montantVente;
                $invoice->montant_paye = $montantPaye ?? 0;
                $invoice->statut = ($invoice->montant_paye >= $invoice->montant_total) ? 'Payée' : 'Partielle';
                $invoice->save();

                if ($montantPaye && $montantPaye > 0) {
                    Payment::updateOrCreate(
                        ['sale_id' => $sale->id],
                        [
                            'invoice_id' => $invoice->id,
                            'montant' => $montantPaye,
                            'mode_paiement' => $modePaiement,
                            'statut' => 'Payée',
                            'date_paiement' => now(),
                        ]
                    );
                }
            }
        });

    }

    /**
     * Crée ou met à jour une facture pour une vente sans réservation.
     */
    public function updateInvoiceAndPaymentForSale(
        Sale $sale,
        float $montantVente,
        ?float $montantPaye = null,
        string $modePaiement = 'Espèces'
    ): void {
        DB::transaction(function () use ($sale, $montantVente, $montantPaye, $modePaiement) {

            // 🔹 Cherche une facture existante
            $invoice = Invoice::where('sale_id', $sale->id)->first();

            if (!$invoice) {
                $invoice = new Invoice();
                $invoice->sale_id = $sale->id;
                $invoice->montant_total = 0;
                $invoice->montant_paye = 0;
                $invoice->statut = 'Partielle';
            }

            // 🔹 Met à jour proprement sans cumuler
            $oldSaleTotal = $sale->getOriginal('total') ?? 0;
            $invoice->montant_total = max(0, ($invoice->montant_total - $oldSaleTotal) + $montantVente);
            $invoice->montant_paye = max(0, ($invoice->montant_paye - $oldSaleTotal) + ($montantPaye ?? 0));
            $invoice->statut = ($invoice->montant_paye >= $invoice->montant_total) ? 'Payée' : 'Partielle';
            $invoice->save();

            // 🔹 Paiement
            if ($montantPaye && $montantPaye > 0) {
                Payment::updateOrCreate(
                    ['sale_id' => $sale->id],
                    [
                        'invoice_id' => $invoice->id,
                        'montant' => $montantPaye,
                        'mode_paiement' => $modePaiement,
                        'statut' => 'Payée',
                        'date_paiement' => now(),
                    ]
                );
            }
        });
    }

    /**
     * 
     */
    public function handleInvoiceAndPayment(
        ?Reservation $reservation = null,
        ?Sale $sale = null,
        float $montantVente,
        ?float $montantPaye = null,
        string $modePaiement = 'Espèces'
    ): void {

        DB::transaction(function () use ($reservation, $sale, $montantVente, $montantPaye, $modePaiement) {

            /**
             * ----------------------------------------------------
             * 1️⃣ CAS : VENTE AVEC RÉSERVATION
             * ----------------------------------------------------
             */
            if ($reservation) {

                $invoice = Invoice::firstOrNew([
                    'reservation_id' => $reservation->id
                ]);

                $invoice->sale_id = $sale?->id ?? $invoice->sale_id;
                $invoice->montant_total = $montantVente;
                $invoice->montant_final = $montantVente;

                // ⚠️ Ne réécrit pas le montant payé si $montantPaye est null
                if ($montantPaye !== null) {
                    $invoice->montant_paye = $montantPaye;
                }

                // Statut facture
                if ($invoice->montant_paye >= $invoice->montant_final) {
                    $invoice->statut = 'Payée';
                } elseif ($invoice->montant_paye > 0) {
                    $invoice->statut = 'Partielle';
                } else {
                    $invoice->statut = 'En attente';
                }

                // Appliquer remise du dernier paiement si existant
                if ($reservation->payments()->exists()) {
                    $lastPay = $reservation->payments()->latest()->first();
                    $invoice->remise_amount = $lastPay->remise_amount ?? 0;
                }

                $invoice->save();

                // Paiement automatique si montant payé fourni
                if ($montantPaye !== null && $sale) {
                    Payment::updateOrCreate(
                        ['sale_id' => $sale->id],
                        [
                            'reservation_id' => $reservation->id,
                            'invoice_id' => $invoice->id,
                            'montant' => $montantPaye,
                            'mode_paiement' => $modePaiement,
                            'statut' => 'Payée',
                            'date_paiement' => now(),
                        ]
                    );
                }

                // Mise à jour statut réservation
                $reservation->update([
                    'statut' => ($invoice->montant_paye >= ($invoice->montant_final * 0.5))
                        ? 'Confirmée'
                        : 'En attente'
                ]);

                return; // Fin du cas réservation
            }

            /**
             * ----------------------------------------------------
             * 2️⃣ CAS : VENTE LIBRE → FACTURE SPÉCIALE
             * ----------------------------------------------------
             */
            if ($sale) {

                $invoice = Invoice::firstOrNew([
                    'sale_id' => $sale->id,
                    'reservation_id' => null
                ]);

                $invoice->montant_total = $montantVente;
                $invoice->montant_final = $montantVente;

                // ⚠️ Ne réécrit pas le montant payé si $montantPaye est null
                if ($montantPaye !== null) {
                    $invoice->montant_paye = $montantPaye;
                }

                if ($invoice->montant_paye >= $invoice->montant_final) {
                    $invoice->statut = 'Payée';
                } elseif ($invoice->montant_paye > 0) {
                    $invoice->statut = 'Partielle';
                } else {
                    $invoice->statut = 'En attente';
                }

                $invoice->save();

                if ($montantPaye !== null && $montantPaye > 0) {
                    Payment::updateOrCreate(
                        ['sale_id' => $sale->id],
                        [
                            'invoice_id' => $invoice->id,
                            'montant' => $montantPaye,
                            'mode_paiement' => $modePaiement,
                            'statut' => 'Payée',
                            'date_paiement' => now(),
                        ]
                    );
                }

                return; // Fin cas vente libre
            }

        });
    }

}