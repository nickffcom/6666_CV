<?php

namespace App\Http\Controllers\US;

use App\Repository\HistoryRepo;
use App\Repository\ServiceRepo;
use App\Http\Controllers\Controller;
use App\Models\Notify;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

            $listServiceFromMuaFbNet = Cache::get('muafb.net');
            $listServiceFromMuaViaBm = Cache::get('muaviabm.vn');
            // dd($listServiceFromMuaViaBm);
            if(!isset($listServiceFromMuaFbNet)){
                $priceIncrement = 1.07;
                $listServiceFromMuaFbNet = $this->getDataAndCache('muafb.net',$priceIncrement);
            }
            if(!isset($listServiceFromMuaViaBm)){
                $priceIncrement = 1.07;
                $listServiceFromMuaViaBm = $this->getDataAndCache('muaviabm.vn',$priceIncrement);
            }

            if(isset($listServiceFromMuaFbNet)){
                $listServiceFromMuaFbNet = (array)json_decode($listServiceFromMuaFbNet);
                $ListServiceAds69 = array_merge_recursive($ListServiceAds69,$listServiceFromMuaFbNet);
            }
            if( isset($listServiceFromMuaViaBm)){
                $listServiceFromMuaViaBm = (array)json_decode($listServiceFromMuaViaBm);
                $ListServiceAds69 = array_merge_recursive($ListServiceAds69,$listServiceFromMuaViaBm);
            }

            $me = Auth::user();
            return view('User.home', [
                    'services' => $ListServiceAds69,
                    'notify' => $ListNotify,
                    'payments' => $HistoryPayment,
                    'transactions' => $HistoryTransaction,
                    'me'=>$me,
            ]);
        }catch(Exception $e){
            return "Vui lòng ấn load lại trang ! Xin cảm ơnnn";
            addLogg('HomeController',Conver_ToString($e->getMessage()),LEVEL_EXCEPTION);
        }
    }

    public function napTien(){ 
      
        return view('User.pay');
    }
    public function lichSuNapTien(){
        $me = Auth::user();
        $historyPayment = $this->historyRepo->getHistoryByUser($me->id,NAP_TIEN);
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

    public function getDataAndCache($domain,$incrementPrice){
        $tk = env("USER_API");
        $mk = env("PASS_API");
        $getDataFromApi = Http::get("https://$domain/api/ListResource.php?username=$tk&password=$mk");
                    if($getDataFromApi->ok()){
                        $data = json_decode($getDataFromApi->body());
                        $dataFromAPI=[
                            'VIA'=>[],
                            'BM'=>[],
                            'CLONE'=>[]
                        ];
                        // dd("mới call API ra nè",$data);
                        foreach($data->categories as $item){
                                foreach($item->accounts as $valueTemp){
                                    if(str_contains(mb_strtoupper($item->name),'VIA')
                                    ||str_contains(mb_strtoupper($item->name),'CLONE')
                                    ||str_contains(mb_strtoupper($item->name),'BM'))
                                    { 

                                        if((int)$valueTemp->amount > 3){
                                            foreach(SERVICE as $service ){  // via bm clone
                                                if(str_contains(mb_strtoupper($valueTemp->name), $service)){
                                                    $valueTemp->type_Api = $domain === 'muafb.net' ? 2 : 3;
                                                    $priceLast = intval($valueTemp->price) * $incrementPrice;
                                                    $valueTemp->price = $priceLast > 0 ? $priceLast : 333333;
                                                    array_push($dataFromAPI[$service],$valueTemp);
                                                }
                                            }
                                        }
                                    }
                                }
                        }
                        $expiresAt = Carbon::now()->addMinutes(15);
                        Cache::add($domain, json_encode($dataFromAPI), $expiresAt);
                    }
                    return empty($dataFromAPI['VIA']) ? null : json_encode($dataFromAPI);
    }

}