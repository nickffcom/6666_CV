<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
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
}
