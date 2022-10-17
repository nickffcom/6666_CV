<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\ServiceRepo;
use Illuminate\Http\Request;

class CloneController extends Controller
{
 
    protected $serviceRepo;

    public function __construct(ServiceRepo $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }
    public function index()
    {
        //
    }

   
    public function create() // view thêm clone
    {
        $services = $this->serviceRepo->getServiceWeb();
        $type="clone";
        return view('Admin.Service.add',[
            'services'=>$services,
            'type'=>$type
        ]);
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    public function type(){   // phân loại

    }


   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

 
    public function destroy($id)
    {
        //
    }
}
