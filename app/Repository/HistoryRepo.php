<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Http\Controllers\Concerns\Paginatable;
use App\Models\Data;
use App\Models\History;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HistoryRepo extends BaseRepo{
 

    public function getModel()
    {
        return History::class;
    }

   
    public function getHistory($type){
        return $this->model->where('type',$type)->orderBy("created_at","desc")->take(10)->get();
    }
   
}