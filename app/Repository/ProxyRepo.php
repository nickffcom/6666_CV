<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Models\Proxy;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class ProxyRepo extends BaseRepo{
 

    public function getModel()
    {
        return Proxy::class;
    }

    public function getProxyUser($id){
        $rs = $this->model->where('user_id',$id)->get();
        return $rs;
    }
   
    
}