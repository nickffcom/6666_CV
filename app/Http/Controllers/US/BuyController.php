<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Jobs\SendThongBaoMuaHangQueue;
use App\Models\Data;
use App\Models\History;
use App\Models\Order_service;
use App\Repository\DataRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $type_API = (int)$request->input('type_secret');
        $idBuy = (int)$request->input('id');
        $quantity = (int)$request->input('quantity');
        $result = [];
        try{
            switch ($type_API){
                case 1;
                    $result = $this->BuyDataAds($idBuy,$quantity); // mua từ chính web của mình
                    break;
                case 2 || 3 :
                    $listServiceFromMuaFbNet = Cache::get('muafb.net');
                    $listServiceFromMuaViaBm = Cache::get('muaviabm.vn');
                    if (!isset($listServiceFromMuaFbNet) || !isset($listServiceFromMuaViaBm)) {
                        return RESULT(false,"Vui lòng Load lại trang Home để ấn mua lại");
                    }
                    $listServiceFromMuaFbNet = (array)json_decode($listServiceFromMuaFbNet);
                    $listServiceFromMuaViaBm = (array)json_decode($listServiceFromMuaViaBm);
                    $serviceAll = array_merge_recursive($listServiceFromMuaFbNet,$listServiceFromMuaViaBm);
                    $data = null;
                    foreach($serviceAll[$type] as $value){
                        if((int)$value->id == $idBuy && $value->type_Api == $type_API ){
                            $data = $value;
                            break;
                        }
                    }
                    if(!isset($data)){
                        return RESULT(false,"Dữ liệu k hợp lệ =>> Cánh báo...");
                    }
    
                    $me = Auth::user();
                    $total_money = $quantity* (int)$data->price;
                    if(!($me->money >= (int)$total_money)){
                        return RESULT(false,"Không đủ tiền thì đừng mua shop ơiiiii");
                    }
                    $domain = $type_API == 2 ? 'muafb.net' : 'muaviabm.vn';
                    $getDataFromApi = Http::get("https://$domain/api/BResource.php?username=nickffcom&password=Nqdiencuboy99**&id=$idBuy&amount=$quantity");
                    if(!$getDataFromApi->ok()){
                        addLogg("Failed Api MuaFB","Lỗi".Conver_ToString($getDataFromApi->body()),LEVEL_PRIORITY,$me->id);
                        return RESULT(false,"Lỗi server =>> Báo Admin gấp nhé b ơii");
                    }
    
                    $getDataFromApi = json_decode($getDataFromApi);
                    addLogg("Call Api MuaFB",Conver_ToString($getDataFromApi),LEVEL_PRIORITY,$me->id);
                    if(!$getDataFromApi->status == "success"){
                        return RESULT(false,"Lỗi Hệ thống =>> Báo Admin liền giúp mình nha fb zalo 0397619750");
                    }else if(!isset($getDataFromApi->data->trans_id)){
                        return RESULT(false,"Lỗi server =>> Báo Admin liền giúp mình 0397619750");
                    }
                    $moneyRemain = $me->money  - $total_money;
                    $resultUpdate = $this->userRepo->updateMoney($moneyRemain);
                    $check = 1;
                    $result = $this->BuyDataFromMuaFbNet($quantity,$type,$getDataFromApi,$total_money,$data,$type_API);// mua từ API Muafb.Net 
                    break;
                default:
                    break;            
            }
            return response()->json($result);
        }catch(Exception $e){
                $description = isset($check) ? 'Đã trừ tiền user nhưng bị lỗi' : '';
                addLogg("Func HandleBuy Main".$description,$e->getMessage(),LEVEL_EXCEPTION,Auth::user()->id);
                return RESULT(false,"Báo cho admin gấp nếu thấy có lỗi");
        }
       
    
    }
    

    public function BuyDataFromMuaFbNet($quantity,$type,$getDataFromApi,$total_money,$data,$typeOrder){
        DB::beginTransaction();
        try{

            $me=Auth::user();
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
                    'attr'=>json_encode(DB_VIA_API($uid,$password,$twofa,$email,$password_email,$note,$type,$data->name,$typeOrder)),
                ]);
                array_push($arrData,$dataItem);
            }
        
            foreach ($arrData as  $item) {

                $order_service = new Order_service();
                $order_service->ref_id = $item->id; // ref id = data_id
                $order_service->code = $trans_id;
                $order_service->price_buy = (int)$data->price;
                $order_service->user_id = $me->id;
                $order_service->type = $typeOrder;
                $order_service->save();
            
            }

            $content = "Mua " . number_format($quantity) . " " . $data->name;
            History::create([
                'action_id' => '0 có',
                'content' => $content,
                'type' =>GIAO_DICH, 
                'total_money' => $total_money,
                'action_content' => 'Mua Hàng tại web=))',
                'user_id' => $me->id

            ]);
            $move_location='/order?type='.$type;
            $dataJob['username'] = $me->username;
            $dataJob['content'] = "=>> ".$content;
            $dataJob['tongtien']= $total_money;
            DB::commit();
            dispatch(new SendThongBaoMuaHangQueue($dataJob));
            return ["status"=>true,"message"=>"Mua thành công => Vào lịch sử Gd để xem","move_location"=>$move_location];
        }catch(Exception $e){
            DB::rollBack();
            // $this->userRepo->updateMoney($moneyRemain);
            addLogg("Funciton BuyDataFromMuaFbNet",$e->getMessage(),LEVEL_EXCEPTION,Auth::user()->id);
            return ["status"=>false,"message"=>"Báo ngay cho Admin để xử lý gấp"];
        }
    }

    //Buy Via ,Clone ,BM ở website của mình
    public function BuyDataAds ($idBuy,$quantity){
 
        $service = $this->serviceRepo->checkSerViceExits($idBuy);
        if (!isset($service->id)) {

            return ["status"=>false,"message"=>"Dịch vụ không hợp lệ"];
        }
        $get_service = $this->dataRepo->getdataSeviceLive($idBuy, $quantity); // get data service status live còn hàng
        if ($quantity > count($get_service)) {
            return ["status"=>false,"message"=>'Không đủ số lượng ' . $service['type'] . ' ! Chọn số lượng ít hơn đi ck iuu'];
        }
        
        $price = $service['price'];
        $total_money = (int)($price * $quantity);
        $me = Auth::user();
        DB::beginTransaction();
        try{

            if ($me->money > $total_money && $total_money !=0 && $total_money > 0) {
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
                $dataSend['username'] = $me->username;
                $dataSend['content'] = "=>> ".$content;
                $dataSend['tongtien']= $total_money;
                DB::commit();
                dispatch(new SendThongBaoMuaHangQueue($dataSend));
                return ["status"=>true,"message"=>"Mua thành công => Vào lịch sử Gd để xem","move_location"=>$move_location];
            } else {
                return ["status"=>false,"message"=>'Bạn không đủ ' . number_format($total_money) . ' VNĐ để thực hiện giao dịch!'];
            }
        }catch(Exception $e){
            DB::rollBack();
            addLogg("Funciton BuyData",Conver_ToString($e->getMessage()),LEVEL_EXCEPTION);
            return ["status"=>false,"message"=>"Báo ngay cho Admin để xử lý gấp"];
        }


    }

}
