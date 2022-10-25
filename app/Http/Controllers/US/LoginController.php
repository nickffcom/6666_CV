<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Models\Notify;
use App\Repository\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $userRepo;
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function login(Request $request){

        $credentials = $request->only('username','password');
        $REMEMBER_ME = true;
        if(Auth::attempt($credentials,$REMEMBER_ME)){
            return response()->json(["status"=>true,"message"=>"Đăng nhập thành côngg"]);
        }

        $msg= "Tài khoản / Mật khẩu không chính xác";
        Session::flash("error",$msg);
        Session::flash("username",$request->input('username'));
        Session::flash("password",$request->input('password'));
        return response()->json(["status"=>false,"message"=>$msg]);

    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
    public function UpdateInfoUser(UpdateUser $request){
        $me = Auth::user();
        $pass =$request->input('password');
        if(  Hash::check($pass, $me->password )   !==false  ) {

            $result = $this->userRepo->update($me->id,[
                'password'=>Hash::make($request->input('password')),
    
            ]);
            return response()->json(["status"=>true,"message"=>"Đổi mk thành công pass mới là :$pass"]);

        }else{
            return response()->json(["status"=>false,"message"=>"Cập nhật thất bại =>>MK cũ không hợp lệ"]);
        }
        
    }
}
