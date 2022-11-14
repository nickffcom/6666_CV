<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Models\Order_service;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderServiceRepo extends BaseRepo{
 

    public function getModel()
    {
        return Order_service::class;
    }

   
    public function getOrder($type){  // lấy ra các bộ và số lần mua các bộ đó
        $me= Auth::user();
        return Service::select('*', DB::raw('(SELECT COUNT(DISTINCT code) FROM order_service INNER JOIN data ON (order_service.ref_id = data.id) WHERE service.id = data.service_id AND order_service.user_id = '. $me->id .') as total_count'))
            ->where('type',$type)
            ->get();
    }
    public function getHistoryOrder($type){  // xem order bn lần và giá cả sao
        $me= Auth::user();
        DB::statement("SET SQL_MODE=''");
        // $haha = DB::table('order_service')
        //             ->join('data','data.id','=','order_service.ref_id')
        //             ->join('service','service.id','=','data.service_id')
        //             ->select('order_service.*','service.name','service.type',DB::raw('COUNT(*) AS total_buy'), DB::raw('SUM(order_service.price_buy) AS total_price'))
        //             ->where('service.type',$type)
        //             ->whereRaw('order_service.user_id = ?',[$me->id])
        //             ->groupByRaw('order_service.code')
        //             ->orderByRaw('order_service.id DESC')
        //             ->get()
        //     ;
        $haha = DB::table('order_service')
                    ->join('data','data.id','=','order_service.ref_id')
                    // ->join('service','service.id','=','data.service_id')
                    ->select('order_service.*',DB::raw('COUNT(*) AS total_buy'), DB::raw('SUM(order_service.price_buy) AS total_price'))
                    ->whereRaw('order_service.user_id = ?',[$me->id])
                    ->groupByRaw('order_service.code')
                    ->orderByRaw('order_service.id DESC')
                    ->get()
            ;
        // dd($haha);   
        return $haha;
    }
    
}