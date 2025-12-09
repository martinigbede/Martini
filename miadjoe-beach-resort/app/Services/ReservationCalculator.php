<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class ReservationCalculator
{
    /**
     * Calcule le montant total de la réservation.
     *
     * @param int  $roomTypeId   ID du type de chambre
     * @param bool $litDappoint  True si l'utilisateur veut un lit d'appoint
     * @param int  $personnes    Nombre total de personnes
     * @param int  $days         Nombre de nuits (déjà calculé)
     *
     * @return float Montant total en CFA
     */
    public static function calculateTotal(int $roomTypeId, bool $litDappoint, int $personnes, int $days, int $nbLitsDappoint = 0)
    {
        // 1. Récupération du type de chambre
        $roomType = RoomType::findOrFail($roomTypeId);

        // 2. Prix de base par nuit × nb nuits
        $basePrice = (float)($roomType->prix_base ?? 0) * $days;

        // 3. Tarifs dynamiques
        $litDappointTarif = (float)DB::table('settings')->where('key', 'lit_dappoint_tarif')->value('value') ?? 10000.0;
        $taxeSejourTarif  = (float)DB::table('settings')->where('key', 'taxe_sejour_tarif')->value('value') ?? 1000.0;

        // 4. Le lit d’appoint devient totalement optionnel
        //    Le prix dépend uniquement du nombre de lits choisis
        $litDappointCost = 0.0;

        if ($litDappoint && $nbLitsDappoint > 0) {
            $litDappointCost = $nbLitsDappoint * $litDappointTarif * $days;
        }

        // 5. Taxe de séjour = taxe × nb personnes × nb nuits
        $taxeSejourCost = $taxeSejourTarif * $personnes * $days;

        // 6. Total final
        $total = $basePrice + $litDappointCost + $taxeSejourCost;

        return round($total, 2);
    }

    /**
     * Calcul utilitaire : nombre de nuits entre deux dates.
     */
    public static function getDaysBetween($checkIn, $checkOut)
    {
        try {
            $start = new \DateTime($checkIn);
            $end   = new \DateTime($checkOut);
            $interval = $start->diff($end);

            // Toujours au moins 1 nuit
            return max(1, $interval->days);
        } catch (\Exception $e) {
            return 1;
        }
    }
}
