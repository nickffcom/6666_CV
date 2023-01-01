<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request){
        $customMessage=[
            "password.confirmed" => "Mật khẩu xác nhận k trùng khớp !",
            "required"=>"A cái thèn này , nhập đầy đủ  nghen",
            "min"=>"Trường :attribute ít nhất :min kí tự nhé",
            "max"=>" :attribute tối đa :max kí tự thôi",
        ];
        $validation = Validator::make($request->all(),[
            'username'=>'required|string|max:50|min:6|alpha_dash|without_spaces|unique:user',
            'password'=>'required|confirmed|string|max:50|min:6|alpha_dash|without_spaces',
        ],$customMessage);
        if($validation->fails()){
            $msg ="";
            foreach ($validation->errors()->all() as $message) {
                $msg =$msg. " ".$message."\n\r";
            }
            return response()->json(["status"=>false,"message"=>$msg]);
        }

        try{
            
            $temp = User::create(
               [ 
                'username'=>$request->username,
                'is_admin'=>1,
                'password'=>Hash::make($request->password)
               ]
            );
            $msg="Đăng ký thành công nhé ck iuu";
            return response()->json(["status"=>true,"message"=>$msg]);
        }catch(Exception $e){
            addLogg("Register Controller","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
            return response()->json(["status"=>false,"message"=>"Thất bại-> Vui lòng Đăng ký tài khoản khác"]);
        }
    }
}
