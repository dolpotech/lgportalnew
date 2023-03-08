<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\CronJob::class,
        Commands\CronValidate::class
    ];
    protected function schedule(Schedule $schedule)
    {
        $filePath=storage_path('app/test.txt');
        $schedule->command('backup:data')
            ->everyFiveMinutes()
            ->then(function(){
                Artisan::call('cron:data');

            })
            ->appendOutputTo($filePath);
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
