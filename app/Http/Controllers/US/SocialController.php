<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\DataRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $dataRepo;
    public function __construct()
    {
        // $this->dataRepo = $dataRepo;
    }
    public function rediRectSocial(Request $request){
        // dd($request);
        return Socialite::driver('facebook')->redirect();
    }
    public function handleSocial(){
        try 
        {
            $user = Socialite::driver('facebook')->user();
            
            $numberRd = mt_rand(10000,99000);
            $saveUser = User::updateOrCreate([
                'facebook_id' => $user->id,
            ],[
                'id'=>$user->id,
                'username' => $user->name.$user->id,
                'email' => $user->email,
                'avatar'=> $user->avatar,
                'is_social'=>$user->id,
                'facebook_id'=>(string)$user->id,
                'password' => Hash::make($user->name.'___'.$user->id)
                 ]);
     
            Auth::loginUsingId($saveUser->id);
     
            return redirect()->route('home');
        } catch (Exception $e) {
            return "Lỗi".$e;
        }

    }

    public function delete(Request $request){
        return "OK";
    }
    
}
