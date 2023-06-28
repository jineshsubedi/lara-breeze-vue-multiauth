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
        // $schedule->command('inspire')->hourly();
        // $schedule->command('notice:dispatch')->dailyAt('01:10');
        // $schedule->command('survey:dispatch')->dailyAt('02:10');
        // $schedule->command('event:dispatch')->dailyAt('03:10');
        // $schedule->command('training:notice')->dailyAt('04:10');
        // $schedule->command('outsource:dispatch')->dailyAt('05:10');
        // $schedule->command('outsource_staff:dispatch')->dailyAt('05:10');
        // $schedule->command('onboard:dispatch')->dailyAt('06:00');
        // $schedule->command('newsfeed:dispatch')->dailyAt('00:00');
        // $schedule->command('newsfeedAnniversary:dispatch')->dailyAt('00:10');
        $schedule->command('jobZipFile:Remove')->everyMinute();
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
