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
    public function __construct(DataRepo $dataRepo)
    {
        $this->dataRepo = $dataRepo;
    }
    public function rediRectSocial(Request $request){
        dd($request);
        // return Socialite::driver($request->query('type'))->redirect();
    }
    public function handleSocial(){
        try 
        {
            $user = Socialite::driver('facebook')->user();
     
            $saveUser = User::updateOrCreate([
                'facebook_id' => $user->getId(),
            ],[
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName().'@'.$user->getId())
                 ]);
     
            Auth::loginUsingId($saveUser->id);
     
            return redirect()->route('home');
        } catch (Exception $e) {
               
        }

    }
    
}
