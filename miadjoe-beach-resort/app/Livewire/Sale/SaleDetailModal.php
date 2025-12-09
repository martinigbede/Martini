<?php

namespace App\Livewire\Sale;

use Livewire\Component;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;

class SaleDetailModal extends Component
{
    public ?int $saleId = null;
    public bool $isModalOpen = false;

    public array $saleData = [];
    public array $items = [];
    public ?float $payment_amount = null;
    public ?string $payment_mode = null;
    public float $total = 0;
    public ?float $reste_a_payer = null;

    #[On('openSaleDetailModal')]
    public function openModal(int $saleId)
    {
        $this->saleId = $saleId;
        $this->isModalOpen = true;
        $this->loadSale();
    }

    protected function loadSale()
    {
        $sale = Sale::with(['items.menu', 'payments', 'reservation.client', 'reservation.room', 'invoice'])
            ->find($this->saleId);

        if (!$sale) {
            $this->saleData = [];
            $this->items = [];
            $this->payment_amount = null;
            $this->total = 0;
            $this->reste_a_payer = null;
            return;
        }

        // --- Informations générales de la vente
        $this->saleData = [
            'id' => $sale->id,
            'date' => $sale->date,
            'reservation' => $sale->reservation ? [
                'id' => $sale->reservation->id,
                'client' => $sale->reservation->client->nom ?? null,
                'room' => $sale->reservation->room->nom ?? null,
            ] : null,
        ];

        // --- Articles
        $this->items = $sale->items->map(fn($item) => [
            'menu_id' => $item->menu_id,
            'menu_nom' => $item->menu?->nom ?? 'Menu inconnu',
            'unite' => $item->unite ?? '-',
            'quantite' => $item->quantite,
            'prix_unitaire' => $item->prix_unitaire,
            'total' => $item->total,
            'remise_type'    => $item->remise_type,
            'remise_valeur'  => $item->remise_valeur,
            'est_offert'     => $item->est_offert,
        ])->toArray();

        // --- Paiements liés à la vente
        $totalPaid = $sale->payments->sum('montant');

        // --- Total final à utiliser pour le calcul du reste
        $montantFinal = $sale->invoice?->montant_final ?? $sale->total;
        $this->payment_mode = $sale->payments->last()?->mode_paiement ?? 'Espèces';

        $this->total = $montantFinal;
        $this->payment_amount = $totalPaid;
        $this->reste_a_payer = max(0, $montantFinal - $totalPaid);
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function generatePdf()
    {
        $sale = Sale::with([
            'items.menu', 
            'reservation.client', 
            'reservation.items.room', // Modifié pour accéder à room via items
            'payments', 
            'invoice',
            
        ])->findOrFail($this->saleId);

        // 🧾 Ne pas générer de facture pour les ventes liées à une réservation
        if ($sale->reservation_id) {
            session()->flash('error', 'Les factures pour les ventes liées à une réservation sont générées depuis la réservation.');
            return;
        }

        $totalPaid = $sale->payments->sum('montant');
        $montantFinal = $sale->invoice?->montant_final ?? $sale->total;

        // Calcul du reste à payer
        $resteAPayer = max(0, $montantFinal - $totalPaid);
        
        // Récupération du dernier paiement
        $lastPayment = $sale->payments->last();
        
        // Récupération du motif de remise s'il existe
        $motifRemise = null;
        if ($lastPayment && $lastPayment->motif_remise) {
            $motifRemise = $lastPayment->motif_remise;
        }

        // Format ticket de caisse 80mm
        $pdf = Pdf::loadView('pdf.sale-receipt', [
            'sale' => $sale,
            'items' => $sale->items,
            'total' => $montantFinal,
            'payment_amount' => $totalPaid,
            'reste_a_payer' => $resteAPayer,
            'payment_mode' => $lastPayment->mode_paiement ?? 'Espèces',
            'motif_remise' => $motifRemise,
            // Informations pour les remises si facture existe
            'invoice' => $sale->invoice,
            'payments' => $sale->payments,
        ])->setPaper([0, 0, 226.77, 1000], 'portrait'); // 80mm = 226.77 points

        // Optionnel: forcer le téléchargement automatique
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "ticket_vente_{$sale->id}.pdf"
        );
    }

    public function render()
    {
        return view('livewire.sale.sale-detail-modal');
    }
}
