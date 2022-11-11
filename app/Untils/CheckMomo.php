<?php

namespace App\Utils;

use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckMomo
{


    public function CheckDataFromMomo()
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
                    $username = explode(' ', $username);
                    $username = trim(end($username));
                    $info = User::where('username', $username)->first();
                    if (!empty($info['id'])) {
                        $id = $info['id'];
                        $money = $x['amount'];
                        // fwrite($fp, implode('|', $x) . '|' . date('H:i:s - d/m/Y', time()) . "\n");
                        if (is_numeric($money) && $money > 0) {
                            $update = "UPDATE users SET money = money + $money WHERE uid = " . $id;
                            $resultUpdate = User::where('id', $id)->increment('money', $money);
                            if ($resultUpdate) {
                                History::insert('history', array(
                                    'action_id' => $x['tranId'],
                                    'content' => 'Nạp tiền qua Momo',
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

    public function CheckDataFromVietComBank()
    {

        $now = Carbon::now();
        $time = date('d-m-Y', strtotime($now));
        DB::beginTransaction();
        try {
            $urlApi = "https://sieulike.me/api/utilities/vietcombank";
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
