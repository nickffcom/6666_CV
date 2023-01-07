<?php

namespace App\Console;

use Carbon\Carbon;
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
        $schedule->command('run:vcb')
        ->withoutOverlapping()
        ->everyMinute()
        ->when(function(){
            $listServiceFromMuaFbNet = Cache::get('muafb.net');
            $dataAPI = isset($listServiceFromMuaFbNet) ? json_decode($listServiceFromMuaFbNet) : null;
            if($dataAPI){
                return true;
            }
        })
        ->sendOutputTo(storage_path('logs/checkVcb-' . Carbon::now()->format('Y-m-d') . '.txt'),true);
        

        

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
