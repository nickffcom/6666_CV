<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\HistoryRepo;
use App\Repository\NotifyRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    protected $serviceRepo;
    protected $userRepo;
    protected $historyRepo;
    protected $notifyRepo;
    public function __construct(ServiceRepo $serviceRepo,UserRepo $userRepo,HistoryRepo $historyRepo,NotifyRepo $notifyRepo)
    {
        $this->serviceRepo = $serviceRepo;
        $this->userRepo = $userRepo;
        $this->historyRepo = $historyRepo;
        $this->notifyRepo = $notifyRepo;
    }

    public function type($type='VIA'){   // phân loại
        
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
    public function CongTruTien(Request $request){
        $lists_users  = User::select('username','money')->orderBy('id', 'DESC')->get();
        return view('Admin.trans')->with('lists_users',$lists_users);
    }

    public function HandleCongTruTien(Request $request){
        try{
            $me = Auth::user();
            $userName = $request->input('username');
            $money = $request->input('money');
            $action = $request->input('action',TRU_TIEN);
            $result = $this->userRepo->updateMoneyByUserName($userName,$money,$action);
            $this->historyRepo->create([
                'action_id'=>'Không có',
                'action_content'=>'Không có',
                'content' => 'Nạp tiền vào tài khoản',
                'total_money' => $money,
                'type' => NAP_TIEN,
                'user_id'=>$me->id
            ]);
            return response()->json(["status"=>true,"message"=>"Cập nhật tiền thành công"]);
        }catch(Exception $e){
            return response()->json(["status"=>false,"message"=>"Thất bại rồi người anh ơiii".$e]);
        }
        

    }

    public function ManageUsers(Request $request){
        $list_user = $this->userRepo->getAll();
        return view('Admin.users',[
            'list_user'=>$list_user
        ]);
    }
    
    public function Settings(){
        return view('Admin.settings');
    }
    public function notify(){
        $list_notify = $this->notifyRepo->getAll();
        return view('Admin.notify')->with('lists',$list_notify);
    }
    public function ThongKeDoanhThu(Request $request){
        $thongke = $this->historyRepo->getThongKeDoanhThu();
        // dd($thongke);
        return view('Admin.statics',[
            'count_today'=>$thongke,
            'count_month'=>$thongke,
            'count_all'=>$thongke,
        ]);
    }

    public function LichSuHoatDong(Request $request){
        $lists = $this->historyRepo->getAllHistoryToManage();
        // dd($lists);
        return view('Admin.history',[
            'lists'=>$lists
        ]);
    }
}
