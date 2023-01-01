<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\UserRepo;
use Exception;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepo $userRepo) 
    {
        $this->userRepo = $userRepo;
    }


    // Manage User for admin
    public function detailUser(Request $request){
        try{
            $id = $request->input('uid');
            return $this->userRepo->find($id);
        }catch(Exception $e){
            addLogg("detailUser","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }

    public function ManageUsers(Request $request){
        try{
            $list_user = $this->userRepo->getAll();
            return view('Admin.users',[
                'list_user'=>$list_user
            ]);
        }catch(Exception $e){
            addLogg("ManageUsers","Lỗi:".$e->getMessage(),LEVEL_EXCEPTION);
        }
    }
}
