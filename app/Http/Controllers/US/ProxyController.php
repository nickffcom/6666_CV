<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Repository\ProxyRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProxyController extends Controller
{
    protected $proxyRepo;
    public function __construct(ProxyRepo $proxyRepo)
    {
        $this->proxyRepo = $proxyRepo;
    }


    public function getviewOrderProxyOfUser (Request $request){
        $me = Auth::user();
        $lists = $this->proxyRepo->getProxyUser($me->id);
        $count = isset($lists) ? count($lists) : 0;
        return view('User.order_proxy', [
            'lists'=>$lists,
            'count' =>$count
        ]);

    }
}
