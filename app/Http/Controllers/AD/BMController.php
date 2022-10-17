<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Repository\DataRepo;
use App\Repository\ServiceRepo;
use Illuminate\Http\Request;

class BMController extends Controller
{
    protected $serviceRepo;
    protected $dataRepo;
   public function __construct(ServiceRepo $serviceRepo,DataRepo $dataRepo)
   {
        $this->serviceRepo = $serviceRepo;
        $this->dataRepo = $dataRepo;
   }
    public function index()
    {
        $type='bm';
        $listData = $this->dataRepo->getDataWithStatus(CON_HANG,$type);
 
        return view('Admin.Service.manage',[
            'listData'=>$listData,
            'type'=>$type
        ]);
    }

    
    public function create()
    {
        $services = $this->serviceRepo->getServiceWeb();
        $type="bm";
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
