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
    public static function calculateTotal(int $roomTypeId, $litDappoint, $personnes, $days)
    {
        // 1️⃣ Récupération du type de chambre
        $roomType = RoomType::findOrFail($roomTypeId);

        // 2️⃣ Prix de base par nuit × nombre de nuits
        $basePrice = (float)($roomType->prix_base ?? 0) * $days;

        // 3️⃣ Récupération dynamique des tarifs depuis la table settings
        $litDappointTarif = (float)DB::table('settings')->where('key', 'lit_dappoint_tarif')->value('value') ?? 10000.00;
        $taxeSejourTarif  = (float)DB::table('settings')->where('key', 'taxe_sejour_tarif')->value('value') ?? 1000.00;

        // 4️⃣ Calcul du nombre de lits d’appoint nécessaires automatiquement
        $capacity = (int)($roomType->nombre_personnes_max ?? 2);
        $extraPersons = max(0, $personnes - $capacity);

        // Si dépassement de capacité, on ajoute automatiquement un lit d’appoint par personne en surplus
        $litDappointCost = 0.00;
        if ($extraPersons > 0) {
            $litDappointCost = $extraPersons * $litDappointTarif * $days;
        }

        // Si l’utilisateur coche explicitement “lit d’appoint”, on ajoute au moins un lit même sans dépassement
        if ($litDappoint && $extraPersons === 0) {
            $litDappointCost += $litDappointTarif * $days;
        }

        // 5️⃣ TAXE DE SÉJOUR = taxe × nb personnes × nb nuits
        $taxeSejourCost = $taxeSejourTarif * $personnes * $days;

        // 6️⃣ TOTAL FINAL
        $total = $basePrice + $litDappointCost + $taxeSejourCost;

        // 7️⃣ Retour arrondi
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
