<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Repository\DataRepo;
use App\Repository\ServiceRepo;
use Exception;
use Illuminate\Http\Request;

class ViaController extends Controller
{
  
    protected $serviceRepo;
    protected $dataRepo;
    public function __construct(ServiceRepo $serviceRepo,DataRepo $dataRepo)
    {
        $this->serviceRepo = $serviceRepo;
        $this->dataRepo = $dataRepo;
    }
    public function index()   // quản lí via
    {
        $listData = $this->dataRepo->getDataWithStatus(CON_HANG,'via');
        $type='via';
        return view('Admin.Service.manage',[
            'listData'=>$listData,
            'type'=>$type
        ]);
        // dd($listData);
       
    }

   
    public function create() // view thêm via
    {
  
        $services = $this->serviceRepo->getServiceWeb();
        $type="via";
        return view('Admin.Service.add',[
            'services'=>$services,
            'type'=>$type
        ]);
    }

    public function type(){   // phân loại

    }

    public function store(Request $request)
    {
        // dd($request);
        $dataInput = $request->input('data',null);
        $typeId = $request->input('type_id',null);
        if(!isset($dataInput) || !is_numeric($typeId) ){
            return response()->json(["status"=>false,"message"=>"Phải có dữ liệu và chọn loại "]);
        }
        $checkService = $this->serviceRepo->checkSerViceExits($typeId);
        if(!isset($checkService)){
            return response()->json(["status"=>false,"message"=>"Vui lòng chọn loại hợp lệ"]);
        }
        $data=trim($dataInput);
        $data = explode("\n", $data);
	    $data = array_map('trim', $data);

        $succes = 0;
        $error = 0;
        $dataErr=[];
        try{
            foreach($data as $item){
                list($uid, $password,$twofa,$email, $password_email,$note) = explode('|', $item);

                if(strlen($uid)< 0){
                    $error++;
                    array_push($dataErr,$uid);
                }
                
                $resultAdd = Data::create([
                    'status'=>CON_HANG,
                    'service_id'=>$typeId,
                    'attr'=>json_encode(DB_VIA($uid,$password,$twofa,$email,$password_email,$note))
                ]);
                if($resultAdd){
                    $succes++;
                }else{
                    $error++;
                    array_push($dataErr,$uid);
                }
            }
            return response()->json(["status"=>true,"message"=>"Thành công nhé:".$succes." & thất bại:".$error ." & ".$dataErr]);
        }catch(Exception $e){
            return response()->json(['status'=>false,"message"=>"Error".$error."--".$succes]);
        }
       
    }

    
    public function show($id)
    {
        $result = $this->dataRepo->find($id);
        return response()->json($result);
        // dd("show id");
    }

    
    public function edit($id)
    {
        dd("edit id");
    }

    
    public function update(Request $request, $id)
    {
        dd('update');
    }

  
    public function destroy($id)
    {
        dd('destroy');
    }
}
