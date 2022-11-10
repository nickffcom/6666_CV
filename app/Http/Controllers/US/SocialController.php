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
    public function rediRectSocial($type){
        // dd($request);
        return Socialite::driver($type)->redirect();
    }
    public function handleSocial($type){
        try 
        {
            $user = Socialite::driver($type)->user();
            // 3362005910793713
            $numberRd = mt_rand(10000,99000);
            $idUser = $user->getId();
            $email = $user->getEmail();
            $nickName = $user->getName();
            $avatar = $user->getAvatar();
            $typeSocial = ($type === 'facebook') ? FACEBOOK : GOOGLE;
            $createUser = User::updateOrCreate(
                    [
                      'social_id' => $idUser,
                    ],
                    [
                    'username' => $nickName." ".strtoupper($type)." ".$numberRd,
                    'email' => $email,
                    'social_id' => $idUser,
                    'type_social'=>$typeSocial,
                    'avatar'=>$avatar,
                    'password' => Hash::make($email."999")
                    ]
            );
                Auth::login($createUser);
                return redirect('/');
            
        } catch (Exception $e) {
            return "Lỗi";
        }

    }

    public function delete(Request $request){
        return "OK";
    }
    
}
