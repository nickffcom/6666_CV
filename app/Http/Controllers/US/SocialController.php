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
     
            $saveUser = User::updateOrCreate([
                'id' => $user->id,
            ],[
                // 'username' => $user->name,
                'email' => $user->email,
                'avatar'=> $user->avatar,
                'is_social'=>FACEBOOK,
                'password' => Hash::make($user->name.'___'.$user->id)
                 ]);
     
            Auth::loginUsingId($saveUser->id);
     
            return redirect()->route('home');
        } catch (Exception $e) {
               
        }

    }

    public function delete(Request $request){
        return "OK";
    }
    
}
