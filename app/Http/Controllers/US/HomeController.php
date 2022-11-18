<?php

namespace App\Http\Controllers\US;

use App\Repository\HistoryRepo;
use App\Repository\ServiceRepo;
use App\Http\Controllers\Controller;
use App\Models\Notify;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        try{ 

            $ListServiceAds69  = $this->serviceRepo->getServiceWeb();
            // dd($ListServiceAds69);
            $ListNotify = $this->notify->select('content')->get();
            $HistoryPayment = $this->historyRepo->getHistory(NAP_TIEN);   // lịch sử nạp tiền
            $HistoryTransaction = $this->historyRepo->getHistory(GIAO_DICH);  // lịch sử giao dịch
            // dd($ListServiceAds69);

            $listServiceFromMuaFbNet = Cache::get('muafb.net');

            if(isset($listServiceFromMuaFbNet)){
            $listServiceFromMuaFbNet=json_decode($listServiceFromMuaFbNet);
            //    dd("Có sẵn",$listServiceFromMuaFbNet);
            foreach($listServiceFromMuaFbNet as $key=>$value){
                    foreach($value as $valueTiep){
                        if(isset($valueTiep)){
                            array_push($ListServiceAds69[$key],$valueTiep);
                        }
                    }
            }

            }else{
                $getDataFromApi = Http::get('https://muafb.net/api/ListResource.php?username=nickffcom&password=noname2d');
                if($getDataFromApi->ok()){
                    $data = json_decode($getDataFromApi->body());
                    // dd("mới call API ra nè",$collection);
                    $collection = collect($data->categories)->filter(function ($item, $key) {
                            return str_contains(mb_strtoupper($item->name), 'VIA')||str_contains(mb_strtoupper($item->name), 'CLONE')||str_contains(mb_strtoupper($item->name), 'BM');
                    });   
                    
                    $dataFromAPI=[
                        'VIA'=>[],
                        'BM'=>[],
                        'CLONE'=>[]
                    ];
                    // dd("mới call API ra nè",$collection);
                    foreach($collection as $item){
                        foreach($item->accounts as $valueTemp){
                            if((int)$valueTemp->amount > 5){
                                foreach(SERVICE as $service ){  // via bm clone
                                    if(str_contains($item->name, $service)){
                                        array_push($dataFromAPI[$service],$valueTemp);
                                    }
                                }
                            }
                        }
                        
                    }
                    // dd("sau khi lọc xong",$dataFromAPI);
                    $expiresAt = Carbon::now()->addMinutes(10);
                    Cache::add('muafb.net', json_encode($dataFromAPI), $expiresAt);
                    foreach($dataFromAPI as $key =>$value){
                        foreach($value as $data){
                            Service::firstOrCreate(
                                [
                                    'from_api'=>API_MUAFB,
                                    'secret_api'=>(int)$data->id,
                                    'price'=>(int)$data->price,
                                ],
                                [
                                    'description'=>$data->description,
                                    'type'=>$key,
                                ]
                            );
                        }
                        
                    }
                    foreach($dataFromAPI as $key=>$value){
                        foreach ($value as $valueTiep) {
                            array_push($ListServiceAds69[$key], $valueTiep);
                        }
                    }
                }else{
                    // Log::error("Get API MuaFb.Net éo được ck ơi".now()->toString());
                }
            }

        // dd($ListServiceAds69);
            $me = Auth::user();
            return view('User.home', [
                'services' => $ListServiceAds69,
                'notify' => $ListNotify,
                'payments' => $HistoryPayment,
                'transactions' => $HistoryTransaction,
                'me'=>$me,
            ]);
        }catch(Exception $e){
            addLogg('HomeController',Conver_ToString($e->getMessage()),LEVEL_EXCEPTION);
        }
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
        $list = $this->historyRepo->getHistory(GIAO_DICH,20);
        $count = count($list);
        return view('User.history_buy',[
            'lists'=>$list,
            'counts'=>$count
        ]);
    }
}