<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\NotifyRepo;
use Exception;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    protected $notifyRepo;

    public function __construct(NotifyRepo $notifyRepo){
        $this->notifyRepo = $notifyRepo;
    }

    public function getDetailNotify(Request $request){
        try{
            $notify = $this->notifyRepo->find($request->input('id'));
            return $notify;
        }catch(Exception $e){
            addLogg("getDetailNotify","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }
    public function addThongBao(Request $request){
        try{
            $this->notifyRepo->create($request->all());
            return response()->json(["status"=>true, "message"=>"Thêm thành công"]);
        }catch(Exception $e){
            addLogg("addThongBao","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

    public function CapNhatThongBao(Request $request){
        try{
            $id = $request->input('id',1);
            $this->notifyRepo->update($id, $request->all());
            return response()->json(["status"=>true, "message"=>"Cập Nhật thành công"]);
        }catch(Exception $e){
            addLogg("CapNhatThongBao","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

    public function XoaThongBao(Request $request){
        try{
            $id = $request->input('id',1);
            $this->notifyRepo->delete($id);
            return response()->json(["status"=>true, "message"=>"Xóa thành công"]);
        }catch(Exception $e){
            addLogg("XoaThongBao","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

}
