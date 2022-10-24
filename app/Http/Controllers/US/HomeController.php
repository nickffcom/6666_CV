<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Notify;
use App\Models\Service;
use App\Repository\HistoryRepo;
use App\Repository\ServiceRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $serviceRepo;
    protected $notify;
    protected $historyRepo;
    public function __construct(ServiceRepo $serviceRepo, Notify $notify, HistoryRepo $historyRepo)
    {
        $this->serviceRepo = $serviceRepo;
        $this->notify = $notify;
        $this->historyRepo = $historyRepo;
    }
    public function home()
    {
        $ListService = $this->serviceRepo->getServiceWeb();
        $ListNotify = $this->notify->all();
        $HistoryPayment = $this->historyRepo->getHistory(NAP_TIEN);   // lịch sử nạp tiền
        $HistoryTransaction = $this->historyRepo->getHistory(GIAO_DICH);  // lịch sử giao dịch
        // dd($HistoryPayment);


        $me = Auth::user();
        return view('User.home', [
            'services' => $ListService,
            'notify' => $ListNotify,
            'payments' => $HistoryPayment,
            'transactions' => $HistoryTransaction,
            'me'=>$me
        ]);
    }

    public function napTien(){ 
      
        return view('User.pay');
    }
    public function lichSuNapTien(){
        $me = Auth::user();
        $historyPayment = $this->historyRepo->getHistoryByUser($me->id,NAP_TIEN);
        // dd($historyPayment);
        return view('User.history_pay')->with('historyPayment',$historyPayment);
    }
    public function Hotro(){
        return view('User.support');
    }
    public function getTaiKhoan(){
        $me = Auth::user();
        return view('User.profile',[
            'me'=>$me
        ]);
     }
    public function LichSuThanhToan(){
        $list = $this->historyRepo->getHistory('service',20);
        return view('User.history_buy',[
            'lists'=>$list,
            'count'=>count($list)
        ]);
    }
}
