<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Annuler les non-arrivées à 14h10
        $schedule->command('room:release')->dailyAt('14:10');

        // Nettoyer les chambres après les départs à 12h10
        $schedule->command('room:release')->dailyAt('12:10');

        // Mettre à jour automatiquement les réservations chaque minute
        $schedule->command('reservation:auto-update')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}