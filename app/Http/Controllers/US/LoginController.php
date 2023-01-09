<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Http\Traits\ThrottlesAttempts;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use ThrottlesAttempts;
    protected $userRepo;
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function login(Request $request){

        $credentials = $request->only('username','password');
        $credentials['social_id'] =  null ;  // prevent account social login with username and password
        $REMEMBER_ME = true;
        if ($this->hasTooManyAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        if(Auth::attempt($credentials,$REMEMBER_ME)){
            $this->clearAttempts($request);
            return response()->json(["status"=>true,"message"=>"Đăng nhập thành côngg ! Vui lòng chờ load trang"]);
        }
        $this->incrementAttempts($request);
        $msg= "Tài khoản / Mật khẩu không chính xác";
        Session::flash("error",$msg);
        Session::flash("username",$request->input('username'));
        Session::flash("password",$request->input('password'));
        return response()->json(["status"=>false,"message"=>$msg]);

    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/login')->withCookie(cookie()->forget('XHRF_PASSPORT'));
    }
    public function UpdateInfoUser(UpdateUser $request){
        try{

       
        $me = Auth::user();
        $pass =$request->input('password');
        $newPass = $request->input('new_password');
        if(  Hash::check($pass, $me->password )   !==false  ) {

            $result = $this->userRepo->update($me->id,[
                'password'=>Hash::make($newPass),
    
            ]);
            return response()->json(["status"=>true,"message"=>"Đổi mk thành công pass mới là :$newPass"]);

        }else{
            return response()->json(["status"=>false,"message"=>"Cập nhật thất bại =>>MK cũ không hợp lệ"]);
        }

        }catch(Exception $e){
            addLogg("Update Info User","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION,$me->id);
        }
        
    }
}
