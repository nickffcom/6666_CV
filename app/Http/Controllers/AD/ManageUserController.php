<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\UserRepo;
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
        $id = $request->input('uid');
        return $this->userRepo->find($id);
    }

    public function ManageUsers(Request $request){
        $list_user = $this->userRepo->getAll();
        return view('Admin.users',[
            'list_user'=>$list_user
        ]);
    }
}
