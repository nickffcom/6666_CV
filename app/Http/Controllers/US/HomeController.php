<?php

namespace App\Http\Controllers\US;

use App\Models\Notify;
use App\Models\History;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Repository\HistoryRepo;
use App\Repository\ServiceRepo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $ListServiceAds69  = $this->serviceRepo->getServiceWeb();
        $ListNotify = $this->notify->all();
        $HistoryPayment = $this->historyRepo->getHistory(NAP_TIEN);   // lịch sử nạp tiền
        $HistoryTransaction = $this->historyRepo->getHistory(GIAO_DICH);  // lịch sử giao dịch
        // dd($ListServiceAds69);

        $listServiceFromMuaFbNet = Cache::get('muafb.net');

        if(isset($listServiceFromMuaFbNet)){
           $listServiceFromMuaFbNet=json_decode($listServiceFromMuaFbNet);
           foreach($listServiceFromMuaFbNet as $key=>$value){
                foreach($value as $valueTiep){
                    array_push($ListServiceAds69[$key],$valueTiep);
                }
           }

        }else{
            $getDataFromApi = Http::withHeaders([
                'Content-Type' => 'text/html; charset=UTF-8',
            ])->get('https://muafb.net/api/ListResource.php?username=nickffcom&password=noname2d');
           
            if($getDataFromApi->ok()){
                $data = json_decode($getDataFromApi->body());
                $collection = collect($data->categories)->filter(function ($item, $key) {
                        return str_contains($item->name, 'VIA')||str_contains($item->name, 'CLONE')||str_contains($item->name, 'BM');
                });   
                
                $dataFromAPI=[
                    'VIA'=>[],
                    'BM'=>[],
                    'CLONE'=>[]
                ];
                foreach($collection as $item){
                    foreach($item->accounts as $valueTemp){
                        if( (int)$valueTemp->amount > 5){
                            if(str_contains($item->name, 'VIA')){
                                array_push($dataFromAPI['VIA'],$valueTemp);
                            }else if(str_contains($item->name, 'BM')){
                                array_push($dataFromAPI['BM'],$valueTemp);
                            }else if(str_contains($item->name, 'CLONE')){
                                array_push($dataFromAPI['CLONE'],$valueTemp);
                            }
                        }
                    }
                    
                }
                $expiresAt = Carbon::now()->addMinutes(10);
                $ketquaAddCache = Cache::add('muafb.net', json_encode($dataFromAPI), $expiresAt);
                foreach($dataFromAPI as $key=>$value){
                    foreach ($value as $valueTiep) {
                        array_push($ListServiceAds69[$key], $valueTiep);
                    }
                }

            }else{
                Log::error("Get API MuaFb.Net éo được ck ơi",now());
            }
        }

        // dd($ListServiceAds69);
        $me = Auth::user();
        return view('User.home', [
            'services' => $ListServiceAds69,
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
