<?php

namespace App\Console\Commands;
use App\Utils\CheckTransaction;
use Exception;
use Illuminate\Console\Command;

class CronVietComBankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:vcb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Nạp tiền tự động Vcb Qua Api thứ 3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        try{
            // $result = CheckTransaction::CheckDataFromVietComBank();
            // return $result;
            return CheckTransaction::CheckDataFromVietComBank();
        }catch(Exception $e){
            dd($e->getMessage());   
            return $e->getMessage();
        }
        
    }
}
