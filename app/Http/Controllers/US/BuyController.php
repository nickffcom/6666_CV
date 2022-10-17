<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Order_service;
use App\Models\Service;
use App\Repository\DataRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    protected $serviceRepo;
    protected $dataRepo;
    protected $userRepo;

    public function __construct(ServiceRepo $serviceRepo, DataRepo $dataRepo,UserRepo $userRepo)
    {
        $this->serviceRepo = $serviceRepo;
        $this->dataRepo = $dataRepo;
        $this->userRepo = $userRepo;
    }

    //Buy Via ,Clone ,BM
    public function BuyDataAds (Request $request){
        $idBuy = $request->input('id',null);
        $type = $request->input('type');
        $quantity = $request->input('quantity');

        $service = $this->serviceRepo->checkSerViceExits($idBuy);
        if (empty($service)) {

            return response()->json(["status"=>false,"message"=>"Dịch vụ không hợp lệ"]);
        }
        $get_service = $this->dataRepo->getdataSeviceLive($idBuy, $type); // get data service status live còn hàng

        if ($quantity > count($get_service)) {
           
            return response()->json(["status"=>false,"message"=>'Không đủ số lượng ' . $service['type'] . ' ! Chọn số lượng ít hơn đi ck iuu']);
        }
        
        $price = $service['price'];
        $total_money = ($price * $quantity);
        $me = Auth::user();
        
        if ($me->money > $total_money) {
            $ref_code = md5(rand(0, 999999) . time() . microtime() . base64_encode(time()) . base64_encode(microtime()) . rand(0, 999999));
            $time = Carbon::now();
            foreach ($get_service as  $data) {

                $order_service = new Order_service();
                $order_service->ref_id = $data['id'];
                $order_service->code = $ref_code;
                $order_service->price_buy = $price;
                $order_service->user_id = $me->id;
                $order_service->save();
             
              $this->dataRepo->updateStatusData($data['id'],HET_HANG);
              
            }

            $content = "Mua " . number_format($quantity) . " " . $service['name'];
            History::create([
                'action_id' => '0 rõ',
                'content' => $content,
                'type' =>'transaction', 
                'total_money' => $total_money,
                'action_content' => '))',
                'user_id' => $me->id

            ]);
            $moneyRemain = $me->money  - $total_money;
            $resultMoney = $this->userRepo->updateMoney($moneyRemain);

             return response()->json(["status"=>true,"message"=>"Mua thành công => Vào lịch sử Gd để xem"]);
        } else {
           
            return response()->json(["status"=>true,"message"=>'Bạn không đủ ' . number_format($total_money) . ' VNĐ để thực hiện giao dịch!']);
        }

        // $rs = $this->service->buyData($idBuy,$type,$quantity);

    }



}
