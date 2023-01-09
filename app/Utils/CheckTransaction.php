<?php

namespace App\Utils;

use App\Jobs\SendThongBaoNapTienQueue;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTransaction
{


    public static function CheckDataFromVietComBank()
    {
        DB::beginTransaction();
        try {
                $begin = now()->addDay(0)->format('d/m/Y'); // check tối đa 3 ngày
                $end =  now()->format('d/m/Y');
                $username ="0397619750";
                $password = env("PASS_VCB","withLove");
                $accountNumber ="1016650160";
                $urlApi = "https://apibank.otpsystem.com/api/vcb/transactions";
                $data=[
                    "begin"=>$begin,
                    "end"=>$end,
                    "username"=>$username,
                    "password"=>$password,
                    "accountNumber"=>$accountNumber
                ];
                $result = Http::post($urlApi,$data);

                if (!$result->body()) {
                    addLogg("Call VCB","CALL VCB LỖI OY```! ",LEVEL_DEFAULT);
                    DB::commit();
                    return "Call Lỗi";
                }
                $data = json_decode($result, true);
                if(!isset($data['transactions'])){
                    return ;
                }
                foreach ($data['transactions'] as $x) {

                    if (isset($x['Description']) && $x['CD'] == "+") {
                        $transactionID = preg_replace('/\s+/', '', $x['Reference']);
                        $amount = (int)str_replace(",","",$x['Amount']) ;
                        $description = $x['Description'];
                        $transactionDate = $x['TransactionDate'];
                        $now = $end;  // 30/12/2022
                        if($transactionDate == $now && $amount > 30000){
                            $userAdd = null;
                            if(preg_match('/naptien\s(.*?)\W/i',$description,$match)){ // naptien hainao\s
                                $userAdd = $match[1];
                            }else if(preg_match('/nap\stien\s(.*?)\W/i',$description,$match)){
                                $userAdd = $match[1];
                            }
                            else if(preg_match('/naptien(.*?)\Z/',$description,$match)){
                                $userAdd = $match[1];
                            }
                            else if(preg_match('/nap\stien(.*?)\Z/',$description,$match)){
                                $userAdd = $match[1];
                            }
                            if(isset($userAdd)){
                                $username = preg_replace('/\s+/', '', $match[1]);
                                $user = User::where('username', trim($username))->first();
                                if (isset($user->id)) {
                                    $check = History::where(
                                        [
                                        'user_id'=>$user->id,
                                        'action_id'=>$transactionID,
                                        ])
                                        // ->whereDate('created_at','=',Carbon::today()->toDateString())->toSql()
                                        // ->whereRaw("DATE_FORMAT(created_at, '%Y%m%d') = {$now->format('Ymd')}")
                                        ->first()
                                        ;
                                    $money = (int)$amount;
                                    if (!isset($check->id)) {
                                        $resultUpdate = $user->increment('money', $money);
                                        if ($resultUpdate) {
                                            $resultCreate = History::create([
                                                'action_id' => $transactionID,
                                                'content' => 'Nạp tiền Auto qua VCB',
                                                'total_money' => $money,
                                                'type' => NAP_TIEN,
                                                'user_id' => $user->id
                                            ]);
                                            
                                        }
                                        $dataSend['username'] = $username;
                                        $dataSend['sotiendanap']= $money;
                                        $dataSend['thongtinthem'] = "Nạp tiền Auto Qua VCB";
                                        dispatch(new SendThongBaoNapTienQueue($dataSend));
                                    }
                                }
                            }
                        
                        }
                        
                    }
                }
                DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            addLogg("Exception VCB","=>>Lỗi là:" . $e->getMessage(),LEVEL_EXCEPTION,null,null);
        }
    }

    public static function CheckDataFromMomo()
    {

        $now = Carbon::now();
        $time = date('d-m-Y', strtotime($now));
        DB::beginTransaction();
        try {
            $urlApi = "https://sieulike.me/api/utilities/momo";
            $email = "cuboy99x@gmail.com";
            $passMomo = "haizzzhuoccc";
            $dataPost = [
                'email' => $email,
                'password' => $passMomo
            ];
            $result = Http::post($urlApi, $dataPost);

            if (!$result->body()) {

                Log::error("Get API MOMO Không Thành Công Lúc =>>" . $time);
                return;
            }
            $data = json_decode($result, true);
            if (empty($data['data'])) {
                return;
            }
            $arr_id = "Cũng éo biết lun =)) ";
            $reg = "Éo biết là cái gì luôn";
            foreach ($data['data'] as $x) {

                if (preg_match($reg, mb_strtolower($x['comment']), $match)) {
                    $username = $match[1];
                    $username = str_replace('.', ' ', $username);
                    $username = explode(' ', $username);
                    $username = trim(end($username));
                    $info = User::where('username', $username)->first();
                    if (!empty($info['id'])) {
                        $id = $info['id'];
                        $money = $x['SoTienGhiNo'];
                        $money = str_replace(',', '', $money);
					    $money = trim($money);
                        // fwrite($fp, implode('|', $x) . '|' . date('H:i:s - d/m/Y', time()) . "\n");
                        if (is_numeric($money) && $money > 0) {
                            $update = "UPDATE users SET money = money + $money WHERE uid = " . $id;
                            $resultUpdate = User::where('id', $id)->increment('money', $money);
                            if ($resultUpdate) {
                                History::insert('history', array(
                                    'action_id' => $x['tranId'],
                                    'content' => 'Nạp tiền qua VietComBank',
                                    'total_money' => $money,
                                    'type' => NAP_TIEN,
                                    'id' => $id
                                ));
                                DB::commit();
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error("Exception đoạn CheckData Momo lúc:" . $time . "=>>Lỗi là:" . $e);
        }
    }
}
