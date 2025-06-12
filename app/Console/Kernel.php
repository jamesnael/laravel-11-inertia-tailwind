<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('cron:wipeexpiredregis')
                ->everyMinute()
                ->withoutOverlapping()
                ->before(function () {
                    \Log::info('Start cron wipe data for expired registration.');
                })
                ->onSuccess(function () {
                    \Log::info('Cron wipe data for expired registration ended successfully.');
                })
                ->onFailure(function () {
                    \Log::info('Cron wipe data for expired registration ended in failure.');
                });
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
