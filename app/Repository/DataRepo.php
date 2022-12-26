<?php

namespace App\Repository;

use App\Repository\BaseRepo;
use App\Models\Data;
use Illuminate\Support\Facades\Auth;

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

    $lists = $this->model->selectRaw('order_service.*, data.*')
    ->join('order_service', 'data.id', '=', 'order_service.ref_id')
    ->where('order_service.code', $code)
    ->where('order_service.user_id', $me->id);

    $lists = $lists->get();          
    return $lists;
  }

  public function addServiceData($request)
  {
  }
}
