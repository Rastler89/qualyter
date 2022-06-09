<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Cmixin\BusinessDay;


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
        BusinessDay::enable('Carbon\Carbon');
        /*$schedule->command('note:monthly')->when(function () {
            return \Carbon\Carbon::now()->isSameDay($this->findFirstBusinessDay());
        })->at('10:00');*/
        $schedule->command('note:monthly')->hourly()->runInBackground()->emailOutputOnFailure('daniel.molina@optimaretail.es');
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
    
    protected function findFirstBusinessDay() {
        $first = \Carbon\Carbon::now()->firstOfMonth();
        if ($first->isBusinessDay()) {
            return $first;
        }
        return $first->nextBusinessDay();
    }
}
