<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;

class AutoUpdateReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:auto-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour automatiquement toutes les réservations et leurs factures en recalculant le total et les ventes associées';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Début de la mise à jour des réservations ===');

        // Charger toutes les réservations avec leurs ventes, paiements et factures
        $reservations = Reservation::with(['sales', 'invoice', 'payments'])->get();

        $updatedCount = 0;

        foreach ($reservations as $reservation) {
            try {
                // 🔹 Recalcul complet via la méthode existante
                $reservation->recalculerTotal();
                $updatedCount++;
            } catch (\Throwable $e) {
                $this->error("Erreur sur la réservation #{$reservation->id} : " . $e->getMessage());
            }
        }

        $this->info("✅ Total des réservations mises à jour : {$updatedCount}");
        $this->info('=== Mise à jour terminée avec succès ===');

        return Command::SUCCESS;
    }
}
