<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Models\Data;
use App\Models\History;
use App\Models\Order_service;
use App\Models\Service;
use App\Repository\DataRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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


    public function HandleBuy(BuyRequest $request){
        $type = $request->input('type'); // trường hợp mua = API Muafb.net
        $idBuy = $request->input('id');
        $quantity = $request->input('quantity');
        DB::beginTransaction();
        try{
            $result = [];
            if(isset($type)){    
                $result = $this->BuyDataFromMuaFbNet($idBuy,$quantity,$type);// mua từ API Muafb.Net 
            }else{
                $result = $this->BuyDataAds($idBuy,$quantity); // mua từ chính web của mình
            }

            if($result['status'] === false ){
                return response()->json($result);
            }else if($result['status'] === true ){
                DB::commit();
                return response()->json($result);
            }
        }catch(Exception $e){
            DB::rollBack();
            Log::error("Lỗi Exception khi vào mua buy data:".$e);
            return response()->json(["status"=>false,"message"=>"Báo ngay cho Admin để xử lý gấp"]);
        }
    
    }
    

    public function BuyDataFromMuaFbNet($idBuy,$quantity,$type){
        $listServiceFromMuaFbNet = Cache::get('muafb.net');
        if (!isset($listServiceFromMuaFbNet)) {
            return ["status"=>false,"message"=>"Vui lòng Load lại trang Home để ấn mua lại"];
        }
        $listServiceFromMuaFbNet = json_decode($listServiceFromMuaFbNet);
        // dd($listServiceFromMuaFbNet->$type);
        $data = null;
        foreach($listServiceFromMuaFbNet->$type as $value){
            if((int)$value->id == $idBuy){
                $data = $value;
            }
        }
        if(!isset($data)){
            return ["status"=>false,"message"=>"Dữ liệu k hợp lệ =>> Cánh báo..."];
        }

        $me = Auth::user();
        $total_money = $quantity* (int)$data->price;
        if(!$me->money > (int)$total_money){
            return ["status"=>false,"message"=>"Không đủ tiền thì đừng mua shop ơiiiii"];
        }

        $getDataFromApi = Http::get("https://muafb.net/api/BResource.php?username=nickffcom&password=noname2d&id=$idBuy&amount=$quantity");
        if(!$getDataFromApi->ok()){
            return ["status"=>false,"message"=>"Lỗi server =>> Báo Admin gấp nhé b ơii"];
        }

        $getDataFromApi = json_decode($getDataFromApi);
        if(!$getDataFromApi->status == "success"){
            Log::error($me->username."Gọi API trả về  thất bại hay sao ấy",Conver_Object_to_Array($getDataFromApi));
            return ["status"=>false,"message"=>"Lỗi server =>> Báo Admin liền giúp mình 0397619750"];
        }else if(!isset($getDataFromApi->data->trans_id)){
            Log::error($me->username."Gọi API mua thành công nhưng lại bị thất bại =>> Ko có mã giao dịch",Conver_Object_to_Array($getDataFromApi));
            return ["status"=>false,"message"=>"Lỗi server =>> Báo Admin liền giúp mình 0397619750"];
        }
        Log::error("Đã gọi API thành công 1 lần".json_encode($getDataFromApi));
        $giaSuData= $getDataFromApi->data;
        $trans_id =$getDataFromApi->data->trans_id;
        $arrData = []; // data đã lưu;
        foreach($giaSuData->lists as $itemData){
            $arrAccount = explode('|', $itemData->account);

            $uid = isset($arrAccount[0]) ? $arrAccount[0] :'';
            $password = isset($arrAccount[1]) ? $arrAccount[1] :'';
            $twofa = isset($arrAccount[2]) ? $arrAccount[2] :'';
            $note = isset($arrAccount[3]) ? $arrAccount[3] :'';
            $email = isset($arrAccount[4]) ? $arrAccount[4] :'';
            $password_email = isset($arrAccount[5]) ? $arrAccount[5] :'';
            $dataItem = Data::create([
                'status'=>HET_HANG,
                'from_api'=>API_MUAFB,
                'attr'=>json_encode(DB_VIA_API($uid,$password,$twofa,$email,$password_email,$note,$type,$data->name)),
            ]);
            array_push($arrData,$dataItem);
        }
       
       
        foreach ($arrData as  $item) {

            $order_service = new Order_service();
            $order_service->ref_id = $item->id; // ref id = data_id
            $order_service->code = $trans_id;
            $order_service->price_buy = (int)$data->price;
            $order_service->user_id = $me->id;
            $order_service->save();
          
        }

        $content = "Mua " . number_format($quantity) . " " . $data->name;
        History::create([
            'action_id' => '0 có',
            'content' => $content,
            'type' =>GIAO_DICH, 
            'total_money' => $total_money,
            'action_content' => '=))',
            'user_id' => $me->id

        ]);
        $moneyRemain = $me->money  - $total_money;
        $resultMoney = $this->userRepo->updateMoney($moneyRemain);
        $move_location='/order?type='.$type;
         return ["status"=>true,"message"=>"Mua thành công => Vào lịch sử Gd để xem","move_location"=>$move_location];

    }

    //Buy Via ,Clone ,BM ở website của mình
    public function BuyDataAds ($idBuy,$quantity){
 
        $service = $this->serviceRepo->checkSerViceExits($idBuy);
        if (empty($service)) {

            return ["status"=>false,"message"=>"Dịch vụ không hợp lệ"];
        }
        $get_service = $this->dataRepo->getdataSeviceLive($idBuy, $quantity); // get data service status live còn hàng
        if ($quantity > count($get_service)) {
           
            return ["status"=>false,"message"=>'Không đủ số lượng ' . $service['type'] . ' ! Chọn số lượng ít hơn đi ck iuu'];
        }
        
        $price = $service['price'];
        $total_money = ($price * $quantity);
        $me = Auth::user();
        
        if ($me->money > $total_money) {
            $ref_code = md5(rand(0, 999999) . time() . microtime() . base64_encode(time()) . base64_encode(microtime()) . rand(0, 999999));
            foreach ($get_service as  $data) {

                $order_service = new Order_service();
                $order_service->ref_id = $data['id']; // ref id = data_id
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
                'type' =>GIAO_DICH, 
                'total_money' => $total_money,
                'action_content' => '))',
                'user_id' => $me->id

            ]);
            $moneyRemain = $me->money  - $total_money;
            $resultMoney = $this->userRepo->updateMoney($moneyRemain);
            $move_location='/order?type='.$service->type;
             return ["status"=>true,"message"=>"Mua thành công => Vào lịch sử Gd để xem","move_location"=>$move_location];
        } else {
           
            return ["status"=>false,"message"=>'Bạn không đủ ' . number_format($total_money) . ' VNĐ để thực hiện giao dịch!'];
        }


    }



}
