<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('fetch:pagespeed')
        //          ->timezone('Europe/Amsterdam')
        //          ->dailyAt('03:00');
                 
        // $schedule->command('fetch:carbonfootprint')
        //          ->timezone('Europe/Amsterdam')
        //          ->monthlyOn(1, '03:00');
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
