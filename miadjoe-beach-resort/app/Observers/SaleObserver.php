<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\Reservation;

class SaleObserver
{
    /**
     * Lorsqu'une vente est supprimée
     */
    public function deleted(Sale $sale)
    {
        if ($sale->reservation_id) {
            $reservation = Reservation::find($sale->reservation_id);

        // 🔹 Supprimer la facture liée à cette vente
       // Invoice::where('sale_id', $sale->id)->delete();

            if ($reservation) {
                // 🔹 Recalcul du total sans la vente supprimée
                $reservation->total = max(0, $reservation->total - $sale->total);
                $reservation->save();

                // 🔹 Recalcule aussi la facture et le solde
                if (method_exists($reservation, 'recalculerTotal')) {
                    $reservation->recalculerTotal();
                }
            }
        }
    }

}
