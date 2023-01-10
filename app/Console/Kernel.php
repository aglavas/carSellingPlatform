<?php

namespace App\Console;

use App\Service\AnalyticsHistoryService;
use App\Service\TransactionNotificationService;
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
        $schedule->call(new TransactionNotificationService)->daily();
        $schedule->call(new AnalyticsHistoryService())->dailyAt('03:00');
        $schedule->command('import:vehicles:nl')->hourly();
        $schedule->command('import:vehicles:de')->hourly();
        $schedule->command('import:vehicles:cz')->hourly();
        $schedule->command('bidding:sync:data')->hourly();
        $schedule->command('check:user:data')->daily();
        $schedule->command('bidding:trigger:cron')->everyFiveMinutes();
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
