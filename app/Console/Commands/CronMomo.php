<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronMomo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:momo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job Ngân hàng Momo / Ngân hàng nè người ae';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $this->info('Đã Cron Job xong rồi nè người ae ơiiiiii');
        return Command::SUCCESS;
    }
}
