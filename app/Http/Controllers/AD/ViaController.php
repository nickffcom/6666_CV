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
    public function index(Request $request)   // quản lí via
    {
        $stt = $request->query('status',CON_HANG);
        $listData = $this->dataRepo->getDataWithStatus($stt,'via');
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

        $success = 0;
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
                    $success++;
                }else{
                    $error++;
                    array_push($dataErr,$uid);
                }
            }
            $count=[
                "error"=>$error,
                "success"=>$success
            ];
            return response()->json(["status"=>true,"count"=>$count,"message"=>$dataErr]);
        }catch(Exception $e){
            return response()->json(['status'=>false,"message"=>"Error".$error."--".$success."=>Message:".$e]);
        }
       
    }

    
    public function show($id)
    {
        $result = $this->dataRepo->find($id);
        return response()->json($result);

    }

    
    public function edit($id)
    {
        dd("edit id");
    }

    
    public function update(Request $request, $id)
    {
        $uid = $request->input('uid');
        $pass= $request->input('pass');
        $key2fa = $request->input('key2fa');
        $email= $request->input('email');
        $passmail= $request->input('passmail');
        $note= $request->input('note');

        $this->dataRepo->find($id)->update([
            'attr'=>json_encode(DB_VIA($uid,$pass,$key2fa,$email,$passmail,$note))
        ]);
        return response()->json(["status"=>true,"message"=>"Cập nhật thành công"]);
    }

  
    public function destroy($id)
    {
        $rs = $this->dataRepo->delete($id);
        return response()->json(["status"=>true,"message"=>"Xóa thành công".$rs]);
    }
}
