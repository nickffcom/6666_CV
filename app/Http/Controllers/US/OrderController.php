<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\ViewOrderDetailRequest;
use App\Http\Requests\ViewOrderRequest;
use App\Repository\DataRepo;
use App\Repository\OrderServiceRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    
    protected $orderRepo;
    protected $dataRepo;
    public function __construct(OrderServiceRepo $orderRepo, DataRepo $dataRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->dataRepo = $dataRepo;
    }

    public function getviewOrder(ViewOrderRequest $request)
    {
        $userId = Auth::user()->id;
        $type = $request->query('type');
        $lists_order = $this->orderRepo->getOrder($type);
        $getHistoryOrder = $this->orderRepo->getHistoryOrder($type,$userId);
        $haha = $this->orderRepo->getHistoryOrderAPI($type,$userId);
        $rs = collect([$getHistoryOrder,$haha])->collapse();
        dd($getHistoryOrder,$haha);
        return view('User.order',[
            'lists_order'=>$lists_order,
            'type'=>$type,
            'list' => $rs
        ]);
    }

    
    public function getViewOrderDetailByCode(ViewOrderDetailRequest $request){ 
        $code = $request->query("code");
        $type = $request->query("type");
        $lists = $this->dataRepo->getAllDataOrder($code,$type);
        // dd($lists);
        $view = view('User.view_order')->with('lists',$lists)->with('type',$type)->render();
        return $view;
    }
    
    public function downloadOrderByCode(ViewOrderDetailRequest $request){ // file Txt
        $code = $request->query("code");
        $type = $request->query("type");
        $typeFile = $request->query('typeFile','txt');
        $lists = $this->dataRepo->getAllDataOrder($code,$type);
        if(!isset($lists)){
            return response()->json(["message"=>"Sai"]);
        }
        $lists = $lists->map(function($item,$key){
            if(isset($item->attr)){
                $data = $item->attr->uid . '|' . $item->attr->pass . '|' . $item->attr->key2fa.'|' . $item->attr->email . '|' . $item->attr->passmail. '|'.$item->attr->note    ;
                return $data;
            }
            return null;
        });
        $now=Carbon::now();
       
        if($typeFile =='txt'){
            $fileName = date_format($now,'d-m-Y H:i')."-Ads69.Net";
            $headers=[
                'Content-Type' => 'text/plain',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' =>'attachment; filename='.$fileName.".txt",
            ];
         
            return response()->make(implode("\n", $lists->toArray()), 200, $headers);
        }else if($typeFile =='zip'){
            $time = date('d-m-Y',strtotime($now));
            $fileNameZip = $time. "-Ads69.zip";
            $zip = new \ZipArchive();
            $zip->open($fileNameZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            $zip->addFromString($fileNameZip.'.txt',$lists);
            $zip->close();
            return response()->download($fileNameZip)->deleteFileAfterSend();
        }
 
    }

    

}
