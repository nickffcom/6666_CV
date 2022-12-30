<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

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
        // $schedule->command('run:momo')->cron('2 * * * *');  // cron job momo 2 phút lần
        $schedule->command('run:vcb')->withoutOverlapping()->everyMinute();
        // ->when(function(){
        //     $listServices = Cache::get('');
        //     if(isset($listServices)){
        //         return true;
        //     }else{
        //         dd("else r");
        //     }
        // })
        // ->runInBackground();  // cron job momo 2 phút lần   ->sendOutputTo($filePath);

        

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
