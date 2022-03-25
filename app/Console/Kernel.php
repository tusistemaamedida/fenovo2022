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
        $schedule->command('stock:daily')->dailyAt('23:57')->runInBackground();
        $schedule->command('update:prices')->dailyAt('03:27')->runInBackground();
        // Copias DB / mantiene últimas 7 copias
        $schedule->command('snapshot:cleanup --keep=6')->dailyAt('03:27')->runInBackground();
        $schedule->command('snapshot:create')->dailyAt('03:27')->runInBackground();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
