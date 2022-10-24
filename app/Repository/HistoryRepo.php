<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Http\Controllers\Concerns\Paginatable;
use App\Models\Data;
use App\Models\History;

class HistoryRepo extends BaseRepo{
 

    public function getModel()
    {
        return History::class;
    }

   
    public function getHistory($type){
        return $this->model->where('type',$type)->orderBy("created_at","desc")->take(10)->get();
    }

    public function getHistoryByUser($userId,$type){
        return $this->model->where('type',$type)->where('user_id',$userId)->orderBy("created_at","desc")->get();
    }

    public function getThongKeDoanhThu(){ // nget ạp tiền vào thôi nhé
        $value = $this->model->where('type',NAP_TIEN)
                             ->selectRaw('SUM(total_money) as TONG_TIEN')
                             ->first();

         return $value;
    }

   public function getAllHistoryToManage(){ 
    
        $value = $this->model->with('user')->get();
   }
}