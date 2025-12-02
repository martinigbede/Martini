<?php

namespace App\Console\Commands;

use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReleaseRoomsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour automatiquement le statut des chambres et des réservations selon la date d’arrivée et de départ.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Début de la vérification des statuts des réservations et chambres ===');

        $now = Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i');
        $updatedRoomsCount = 0;
        $updatedReservationsCount = 0;
        $cancelledReservationsCount = 0;

        // ======================================================
        // 🕒 1. ANNULER les réservations "En attente" dont la date d'arrivée est passée (après 14h00)
        // ======================================================
        $pendingReservations = Reservation::where('statut', 'En attente')
            ->whereDate('check_in', '<=', $today)
            ->get();

        foreach ($pendingReservations as $reservation) {
            // Si la date d’arrivée est passée ou si c’est aujourd’hui après 14h00
            if (
                $reservation->check_in < $today ||
                ($reservation->check_in == $today && $currentTime >= '14:00')
            ) {
                $reservation->statut = 'Annulée';
                $reservation->save();
                $cancelledReservationsCount++;

                // Libérer les chambres associées
                foreach ($reservation->rooms as $room) {
                    if ($room->statut !== 'Maintenance') {
                        $room->statut = 'Disponible';
                        $room->save();
                        $updatedRoomsCount++;
                    }
                }
            }
        }

        // ======================================================
        // 🧹 2. TERMINER les réservations dont le départ est aujourd’hui ou passé
        // ======================================================
        $finishedReservations = Reservation::whereNotIn('statut', ['Annulée', 'Terminée'])
            ->where('check_out', '<=', $today)
            ->with('rooms')
            ->get();

        foreach ($finishedReservations as $reservation) {
            foreach ($reservation->rooms as $room) {
                if ($room->statut !== 'Maintenance') {
                    $room->statut = 'Nettoyage';
                    $room->save();
                    $updatedRoomsCount++;
                }
            }

            $reservation->statut = 'Terminée';
            $reservation->save();
            $updatedReservationsCount++;
        }

        // ======================================================
        // 🧽 3. Remettre les chambres en "Disponible" après 1h de nettoyage
        // ======================================================
        $oneHourAgo = Carbon::now()->subHour();

        $roomsToRelease = Room::where('statut', 'Nettoyage')
            ->where('updated_at', '<=', $oneHourAgo) // Nettoyage terminé depuis 1h
            ->get();

        foreach ($roomsToRelease as $room) {
            $room->statut = 'Disponible';
            $room->save();
        }

        // ======================================================
        // ✅ 4. Résumé du traitement
        // ======================================================
        $this->info('--- Bilan du traitement ---');
        $this->info("🕒 Réservations annulées (non arrivées) : {$cancelledReservationsCount}");
        $this->info("🏁 Réservations terminées : {$updatedReservationsCount}");
        $this->info("🧹 Chambres mises à jour (libérées ou nettoyage) : {$updatedRoomsCount}");
        $this->info('✅ Vérification terminée avec succès.');

        return Command::SUCCESS;
    }
}
