<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Http\Controllers\Concerns\Paginatable;
use App\Models\Data;
use App\Models\History;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepo extends BaseRepo{
 

    public function getModel()
    {
        return User::class;
    }

   
   public function updateMoney($money){
    $me = Auth::user();
    $check = $this->model->where('id',$me->id)->update([
        'money'=> $money
    ]);
    return $check;
   }

   public function updateMoneyByUserName($userName,$money,$action){
        $user = $this->model->where('username',$userName)->firstOrFail();
        if($action == CONG_TIEN){
            $moneyCaculate = $user->money + (int)$money;
        }else if ($action == TRU_TIEN){
            $moneyCaculate = $user->money - (int)$money;
        }
            $check = $user->update([
            'money'=> $moneyCaculate
        ]);
        return $check;
   }

   
}