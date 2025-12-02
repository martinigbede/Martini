<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Télécharger une facture PDF (réservation, restaurant ou service divers).
     */
    public function download($id)
    {
        // Charger la facture avec toutes ses relations possibles
        $invoice = Invoice::with([
            'reservation.client',
            'reservation.items.room.roomType',
            'sale.items.menu',
            'sale.reservation.client',
            'diversServiceVente', // 🔹 ajout important
        ])->findOrFail($id);

        // 🔹 Cas 1 : Facture de réservation
        if ($invoice->reservation) {
            $reservation = $invoice->reservation;
            $client = $reservation->client;

            $pdf = Pdf::loadView('livewire.reservation.invoice-a5', [
                'reservation' => $reservation,
                'client' => $client,
            ])->setPaper('a5', 'portrait');

            return $pdf->download("facture_reservation_{$reservation->id}.pdf");
        }

        // 🔹 Cas 2 : Facture de vente restaurant
        if ($invoice->sale) {
            $sale = $invoice->sale;
            $items = $sale->items;
            $payment = $sale->payments()->latest()->first();

            $pdf = Pdf::loadView('pdf.sale-receipt', [
                'sale' => $sale,
                'items' => $items,
                'total' => $sale->total,
                'payment' => $payment,
                'reste_a_payer' => max(0, $sale->total - ($payment->montant ?? 0)),
            ])->setPaper('a5', 'portrait');

            return $pdf->download("facture_vente_{$sale->id}.pdf");
        }

        // 🔹 Cas 3 : Facture de service divers
        if ($invoice->diversServiceVente) {
            $vente = $invoice->diversServiceVente;

            // Charger les items avec le service associé
            $vente->load(['items.service']);

            $items = $vente->items;

            $payments = $vente->payments ?? collect();
            $montantPaye = $payments->sum('montant') ?? 0;
            $reste = max(0, $vente->total - $montantPaye);

            $pdf = Pdf::loadView('pdf.service-invoice', [
                'vente' => $vente,
                'items' => $items,
                'montantPaye' => $montantPaye,
                'reste' => $reste,
            ])->setPaper('a5', 'portrait');

            return $pdf->download("facture_service_{$vente->id}.pdf");
        }

        // 🔹 Aucun type de facture valide trouvé
        abort(404, "Type de facture inconnu ou relations manquantes.");
    }
}
