<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\ViewOrderDetailRequest;
use App\Http\Requests\ViewOrderRequest;
use App\Repository\DataRepo;
use App\Repository\OrderServiceRepo;
use Carbon\Carbon;
use Exception;
use PDF;
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
        try{

        $userId = Auth::user()->id;
        $type = $request->query('type');
        $lists_order = $this->orderRepo->getOrder($type);
        $getHistoryOrder = $this->orderRepo->getHistoryOrder($type,$userId);
        $haha = $this->orderRepo->getHistoryOrderAPI($type,$userId);
        $rs = collect([$getHistoryOrder,$haha])->collapse();
        return view('User.order',[
            'lists_order'=>$lists_order,
            'type'=>$type,
            'list' => $rs
        ]);
        
        }catch(Exception $e){
            addLogg("Get View Order","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION,$userId);
        }
    }

    
    public function getViewOrderDetailByCode(ViewOrderDetailRequest $request){ 
        try{

        $code = $request->query("code");
        $type = $request->query("type");
        $lists = $this->dataRepo->getAllDataOrder($code,$type);
        $view = view('User.view_order')->with('lists',$lists)->with('type',$type)->render();
        return $view;
        }catch(Exception $e){
            $userId = Auth::user()->id;
            addLogg("getViewOrderDetailByCode","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION,$userId);
        }
    }
    
    public function downloadOrderByCode(ViewOrderDetailRequest $request){ // file Txt

        try{
            $code = $request->query("code");
            $type = $request->query("type");
            $typeFile = $request->query('typeFile','txt');
            $lists = $this->dataRepo->getAllDataOrder($code,$type);
            if(!isset($lists)){
                return response()->json(["message"=>"Sai Rồi"]);
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
                $dataZip ="";
                foreach($lists as $item){
                    if(!$dataZip){
                        $dataZip = (string)$item ."\n";
                    }else{
                        $dataZip = $dataZip . $item ."\n";
                    }
                }
                $zip->addFromString($fileNameZip.'.txt',$dataZip);
                $zip->close();
                return response()->download($fileNameZip)->deleteFileAfterSend();
            }
            else if($typeFile =='pdf'){
                $time = date('d-m-Y',strtotime($now));
                $fileNamePdf = $time. "-Ads69.zip";
                $lists = null;
                $code = $request->query("code");
                $type = $request->query("type","Ads69.net");
                $lists = $this->dataRepo->getAllDataOrder($code,$type);
                // $rs = view("User.register")->render();
                // $pdfContent = App::make('dompdf.wrapper');
                // $pdfContent->loadHTML($rs);
                $pdfContent = PDF::loadView('User.view_order',compact('lists','type'));
                return $pdfContent->download("$fileNamePdf.pdf");
                return $pdfContent->stream('myPDF.pdf');
            
            }
        }catch(Exception $e){
            $userId = Auth::user()->id;
            addLogg("downloadOrderByCode","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION,$userId);
        }
 
    }

    

}
