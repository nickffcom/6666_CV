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
        $ListService = $this->serviceRepo->getServiceWeb();
        $ListNotify = $this->notify->all();
        $HistoryPayment = $this->historyRepo->getHistory(NAP_TIEN);   // lịch sử nạp tiền
        $HistoryTransaction = $this->historyRepo->getHistory(GIAO_DICH);  // lịch sử giao dịch
        // dd($ListService);
        $getDataFromApi = Http::withHeaders([
            'Content-Type' => 'text/html; charset=UTF-8',
        ])->get('https://muafb.net/api/ListResource.php?username=nickffcom&password=noname2d');

        if($getDataFromApi->ok()){
            // dd($getDataFromApi->body());
            $data = json_decode($getDataFromApi->body());
            // dd($data);
            $collection = collect($data);
            // $collection = collect($data->categories)->filter(function ($item, $key) {
            //         return str_contains($item->name, 'VIA')||str_contains($item->name, 'CLONE')||str_contains($item->name, 'BM');
            // });   
            $collection->where('categories->name','=','%CLONE%'); 
            dd($collection);
            
            $result = $collection->map(function ($item, $key) {
                // dd($item);
             
                    // dd($key,$item);
                   $collectTemp = collect($item->accounts)->filter(function ($itemTemp, $keyTemp) {
                        // dd($itemTemp);
                        $soluong = (int)$itemTemp->amount;
                        // dd($soluong);
                        if($soluong >5){
                            echo (int)$soluong;
                            echo "kết thúc số lượng||| \n";
                        }
                        // echo "số lượng nè";
                        // echo (int)$soluong;
                        // echo "kết thúc số lượng \n";
                        return $soluong > 5;
                    });
                    // dd($collectTemp);
                  return $collectTemp;  
                
            
            });
            dd($result);
            foreach($data->categories as $key=>$item){
                // dd($key,$item);
                if(in_array($item->name,SERVICE)){
                    dd($key,$item);
                }
            }
        }

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
