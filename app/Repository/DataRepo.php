<?php

namespace App\Repository;

use App\Repository\BaseRepo;
use App\Http\Controllers\Concerns\Paginatable;
use App\Models\Data;
use App\Models\History;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataRepo extends BaseRepo
{


  public function getModel()
  {
    return Data::class;
  }


  public function updateStatusData($id, $status = HET_HANG)
  {
    return Data::where('id', $id)->update([
      'status' => HET_HANG
    ]);
  }
  public function getdataSeviceLive($id, $quantity)
  {
    return Data::where('service_id', $id)
      ->where('status', CON_HANG)
      ->inRandomOrder()->take($quantity)->get();
  }

  public function getDataWithStatus($status, $type)
  {

    $rs = $this->model->whereHas('service', function ($query) use ($type) {
      $query->where('type', $type);
    });
    if (!$status == 'all') {
      $rs = $rs->where('status', $status);
    }
    return $rs->get();
  }

  public function getAllDataOrder($code, $type)
  {  // get các data của 1 lần order
    $me = Auth::user();
    // $lists = $db->rawQuery("SELECT service.id AS service_id, order_service.*, data_service.*, service.name, service.type FROM order_service INNER JOIN data_service ON (data_service.id = order_service.ref_id) INNER JOIN service ON (service.id = data_service.type_id) WHERE order_service.code = '$code' AND order_service.uid = '{$me->uid}'");
    // $lists = $this->model->selectRaw('service.id AS service_id, order_service.*, data.*, service.name, service.type')
    //   ->join('order_service', 'data.id', '=', 'order_service.ref_id')
    //   ->join('service', 'service.id', '=', 'data.service_id')
    //   ->where('order_service.code', $code)
    //   ->where('order_service.user_id', $me->id)
    //   ->get();
    $lists = $this->model->selectRaw('order_service.*, data.*')
    ->join('order_service', 'data.id', '=', 'order_service.ref_id')
    ->where('order_service.code', $code)
    ->where('order_service.user_id', $me->id)
    ->get();
    return $lists;
  }

  public function addServiceData(Request $request)
  {
  }
}
