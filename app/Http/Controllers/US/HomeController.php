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
        $HistoryPayment = $this->historyRepo->getHistory('payment');
        $HistoryTransaction = $this->historyRepo->getHistory('transaction');
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
}
