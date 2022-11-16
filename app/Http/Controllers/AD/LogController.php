<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\LogRepo;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $logRepo;
    public function __construct(LogRepo $logRepo)
    {
        $this->logRepo =$logRepo;
    }
    public function viewIndex(){
        $log = $this->logRepo->getAll();
        // dd($log);
        return view('Admin.Log',[
            'type'=>"OK",
            'logs'=>$log
        ]);
    }
}
