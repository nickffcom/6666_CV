<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\ServiceRepo;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceRepo;
    public function __construct(ServiceRepo $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function type($type='via'){   // phân loại
        
        $service = $this->serviceRepo->getServiceWeb($type);
        return view('Admin.Service.type',[
            'type'=>$type,
            'services'=>$service
        ]);
    }

    public function HandleService(Request $request){ // update service

        $id = $request->input('id');
        $this->serviceRepo->update($id,$request->only('name','description','price'));
        return response()->json(["status"=>true,"message"=>"Cập nhật thành công nhé a trai"]);
    }

    public function addService(Request $request, $type){
        $rs = $this->serviceRepo->create($request->all());
        return response()->json(["status"=>true,"message"=>"Thêm Service $type Thành công"]);
    }

    public function deleteService(Request $request){
        $id = $request->input('id');
        $this->serviceRepo->delete($id);
        return response()->json(["status"=>true,"message"=>"Xóa service Ok nha con vợ"]);
    }

    public function detailService(Request $request,$id){

       $haha = $this->serviceRepo->find($id);
       
       return $haha;
    }

}
