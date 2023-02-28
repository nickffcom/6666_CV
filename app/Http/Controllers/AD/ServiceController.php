<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Http\Requests\CongTruTienRequest;
use App\Http\Requests\TwoFactorRequest;
use App\Http\Traits\ThrottlesAttempts;
use App\Jobs\SendThongBaoCongTienAdminQueue;
use App\Models\User;
use App\Repository\HistoryRepo;
use App\Repository\NotifyRepo;
use App\Repository\ServiceRepo;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    use ThrottlesAttempts;
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
        try{
        $id = $request->input('id');
        $this->serviceRepo->update($id,$request->only('name','description','price'));
        return response()->json(["status"=>true,"message"=>"Cập nhật thành công nhé a trai"]);
        }catch(Exception $e){
            addLogg("HandleService","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

    public function addService(Request $request, $type){
        try{
        $rs = $this->serviceRepo->create($request->all());
        return response()->json(["status"=>true,"message"=>"Thêm Service $type Thành công"]);
        }catch(Exception $e){
            addLogg("addService","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

    public function deleteService(Request $request){
        try{
        $id = $request->input('id');
        $this->serviceRepo->delete($id);
        return response()->json(["status"=>true,"message"=>"Xóa service Ok nha con vợ"]);
        
        }catch(Exception $e){
            addLogg("deleteService","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
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
            $TransactionID = $request->input('transactionID',null);
            $TransactionID = preg_replace('/\s+/', '', $TransactionID);
            $this->userRepo->updateMoneyByUserName($userName,$money,$action);
            $userCongTien = User::where('username',$userName)->firstOrFail();
            $this->historyRepo->create([
                'action_id'=>$TransactionID,
                'action_content'=>'Admin + tiền',
                'content' => 'Nạp tiền vào tài khoản',
                'total_money' => $money,
                'type' => NAP_TIEN,
                'user_id'=> $userCongTien->id
            ]);
            DB::commit();
            $data['username'] = $userCongTien->username;
            $data['tongtien']= $money;
            dispatch(new SendThongBaoCongTienAdminQueue($data));
            return response()->json(["status"=>true,"message"=>"Cập nhật tiền thành công"]);
        }catch(Exception $e){
            DB::rollBack();
            addLogg("HandleCongTruTien","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
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

    public function LichSuHoatDong(Request $request){
        $lists = $this->historyRepo->getAllHistoryToManage();
        return view('Admin.history',[
            'lists'=>$lists
        ]);
    }

    public function handleAuthenTwoFactor(TwoFactorRequest $request){
        $me = Auth::user()->id;
        if($this->hasTooManyAttempts($request)){
            return $this->sendLockoutResponse($request);
        }
        if((int)$request->input('code2fa') === 396956){
            $cookie = cookie('XHRF_PASSPORT', '396956', 45000);
            $this->clearAttempts($request);
            return response('Hello World')->cookie($cookie);
        }else{
            $this->incrementAttempts($request);
            $varDump=[
                "Hacker nhập"=>$request->input('code2fa')
            ];
            addLogg("Hacker Two Factor","Có kẻ muốn vào phá admin =>> Nguy hiểm",LEVEL_PRIORITY,$me,$varDump);
        }

    }

    public function viewHistoryBank(){
        try{

    
        $begin = now()->addDay(0)->format('d/m/Y'); // check tối đa 3 ngày
        $end =  now()->format('d/m/Y');
        $username ="0397619750";
        $password = env("PASS_VCB","withLove");
        $accountNumber ="1016650160";
        $urlApi = "https://apibank.otpsystem.com/api/vcb/transactions";
        $data=[
            "begin"=>$begin,
            "end"=>$end,
            "username"=>$username,
            "password"=>$password,
            "accountNumber"=>$accountNumber
        ];
        $result = Http::post($urlApi,$data);

        if (!$result->body()) {
            addLogg("Call VCB","CALL VCB LỖI OY```! ",LEVEL_DEFAULT);
            DB::commit();
            return "Call Lỗi";
        }
        $data = json_decode($result, true);
        $banks = isset($data['transactions']) ? $data['transactions'] : [];
        $messageErr = $data['message'];
        return view("Admin.history_bank",[
            "banks"=> $banks,
            "messageErr"=>$messageErr
        ]);
        }catch(Exception $e){

        }
    }
}
