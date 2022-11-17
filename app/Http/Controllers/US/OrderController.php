<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Repository\DataRepo;
use App\Repository\OrderServiceRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    protected $orderRepo;
    protected $dataRepo;
    public function __construct(OrderServiceRepo $orderRepo, DataRepo $dataRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->dataRepo = $dataRepo;
    }

    public function getviewOrder(Request $request)
    {
        $type = $request->query('type','via');
        $id =$request->query('id',null);
        $lists_order = $this->orderRepo->getOrder($type);
        $getHistoryOrder = $this->orderRepo->getHistoryOrder($type);
        // dd($lists_order);
        return view('User.Order',[
            'lists_order'=>$lists_order,
            'type'=>$type,
            'list' => $getHistoryOrder
        ]);
    }

    
    public function getViewOrderDetailByCode(Request $request){ 
        $code = $request->query("code");
        $type = $request->query("type");
        $lists = $this->dataRepo->getAllDataOrder($code,$type);
        // dd($lists);
        $view = view('User.view_order')->with('lists',$lists)->with('type',$type)->render();
        return $view;
    }
    
    public function downloadOrderByCode(Request $request){ // file Txt
        $code = $request->query("code");
        $type = $request->query("type");
        $typeFile = $request->query('typeFile','txt');

        $lists = $this->dataRepo->getAllDataOrder($code,$type)->map(function($item,$key){
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
