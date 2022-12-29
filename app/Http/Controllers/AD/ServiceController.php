<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Http\Requests\CongTruTienRequest;
use App\Http\Requests\TwoFactorRequest;
use App\Models\User;
use App\Repository\HistoryRepo;
use App\Repository\NotifyRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('Admin.service.type',[
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

    public function HandleCongTruTien(CongTruTienRequest $request){
        DB::beginTransaction();
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
            DB::commit();
            return response()->json(["status"=>true,"message"=>"Cập nhật tiền thành công"]);
        }catch(Exception $e){
            DB::rollBack();
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

    public function handleAuthenTwoFactor(TwoFactorRequest $request){
        $me = Auth::user()->id;
        if((int)$request->input('code2fa') === 396956){
            $cookie = cookie('XHRF_PASSPORT', '396956', 45000);
            
            return response('Hello World')->cookie($cookie);
        }else{
            $varDump=[
                "Hacker nhập"=>$request->input('code2fa')
            ];
            addLogg("Hacker Two Factor","Có kẻ muốn vào phá admin =>> Nguy hiểm",LEVEL_PRIORITY,$me,$varDump);
        }

    }
}
