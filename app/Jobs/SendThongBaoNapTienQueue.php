<?php

namespace App\Jobs;

use App\Mail\ThongBaoNapTien;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendThongBaoNapTienQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 1;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $address = env("MAIL_ADMIN");
        Mail::to($address)->send(
            new ThongBaoNapTien
            (
                $this->data['username'],
                $this->data["sotiendanap"],
                $this->data["thongtinthem"]
            )
        );

    }
}
