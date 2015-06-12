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
        \App\Console\Commands\SyncReceipts::class,
        \App\Console\Commands\SyncTestAppliesPaidAt::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:receipts')->withoutOverlapping()->dailyAt('02:00');
        $schedule->command('sync:test-applies-paid-at')->withoutOverlapping()->dailyAt('02:10');
    }
}