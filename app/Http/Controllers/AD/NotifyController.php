<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\NotifyRepo;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    protected $notifyRepo;

    public function __construct(NotifyRepo $notifyRepo){
        $this->notifyRepo = $notifyRepo;
    }

    public function getDetailNotify(Request $request){
        $notify = $this->notifyRepo->find($request->input('id'));
        return $notify;
    }
    public function addThongBao(Request $request){
            $id = $request->input('id');
            $this->notifyRepo->create($request->all());
            return response()->json(["status"=>true, "message"=>"Thêm thành công"]);
    }

    public function CapNhatThongBao(Request $request){
        $id = $request->input('id');
        $this->notifyRepo->update($id, $request->all());
        return response()->json(["status"=>true, "message"=>"Cập Nhật thành công"]);
    }

    public function XoaThongBao(Request $request){
        $id = $request->input('id');
        $this->notifyRepo->delete($id);
        return response()->json(["status"=>true, "message"=>"Xóa thành công"]);
    }

}
