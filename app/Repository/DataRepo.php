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

class DataRepo extends BaseRepo{
 

    public function getModel()
    {
        return Data::class;
    }

   
   public function updateStatusData($id,$status=HET_HANG){
        return Data::where('id',$id)->update([
            'status' => HET_HANG
        ]);
   }
    public function getdataSeviceLive($id, $quantity)
    {
        return Data::where('service_id', $id)
            ->where('status', CON_HANG)
            ->inRandomOrder()->take($quantity)->get();
    }

    public function getDataWithStatus($status,$type){
        // $rs = Data::select('data.*',DB::raw("service.price, service.name FROM data INNER JOIN service ON (data.service_id = service.id) WHERE service.type = '$type'"))
        //         //   ->where('status',$status)
        //           ->orderBy('id','desc')
        //           ->get();
        //           return $rs;

        // $rs = $this->model->select("data.*",DB::raw("(SELECT COUNT(*) FROM service where service.id = data.service_id) AS Countmax "))
        $rs = $this->model->where('status',$status)
                          ->with('service',function($query) use ($type){
                            $query->where('type',$type);
                          })
        //   ->dd()
          ->get();
        // $sql = "SELECT data.*, service.price, service.name FROM data INNER JOIN service ON (data.service_id = service.id) WHERE service.type = '$type' AND data.status ='$status' ORDER BY data.status ASC";
        // $rs =DB::select($sql);
        // dd($rs);
          return $rs;


    }
   
}