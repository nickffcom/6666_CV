<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function rediRectSocial($type){
        return Socialite::driver($type)->redirect();
    }
    public function handleSocial($type){
        try 
        {
            $user = Socialite::driver($type)->user();
            // 3362005910793713
            $idUser = $user->getId();
            $email = $user->getEmail();
            $nickName = $user->getName();
            $avatar = $user->getAvatar();
            $typeSocial = ($type == 'facebook') ? FACEBOOK : GOOGLE;
            $createUser = User::updateOrCreate(
                    [
                      'social_id' => $idUser,
                      'type_social'=>$typeSocial
                    ],
                    // $nickName." ".strtoupper($type)." ".$numberRd
                    [
                    'username' => $email,
                    'email' => $email,
                    'social_id' => $idUser,
                    'type_social'=>$typeSocial,
                    'avatar'=>$avatar,
                    'password' => Hash::make($email."999")
                    ]
            );
                Auth::login($createUser,true);
                return redirect('/');
            
        } catch (Exception $e) {
            addLogg("handleSocial","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
            return "Lỗi".$e;
        }

    }

    public function delete(Request $request){
        return "OK";
    }
    
}
