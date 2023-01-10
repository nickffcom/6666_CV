<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Models\Logg;
use App\Repository\LogRepo;

class LogController extends Controller
{
    protected $logRepo;
    public function __construct(LogRepo $logRepo)
    {
        $this->logRepo =$logRepo;
    }
    public function viewIndex(){
        $log = $this->logRepo->getAll();
        return view('Admin.Log',[
            'type'=>"OK",
            'logs'=>$log
        ]);
    }
    public function delete(Logg $log){
        $result = $log->delete();
        return response()->json(["status"=>true,"message"=>"Xóa thành công"]);
    }
}