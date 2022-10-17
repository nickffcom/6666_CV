<?php

namespace App\Repository;

use App\Repository\BaseRepo;
use App\Http\Controllers\Concerns\Paginatable;
use App\Models\Data;
use App\Models\History;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceRepo extends BaseRepo
{


    public function getModel()
    {
        return Service::class;
    }

    public function getServiceWeb($type = null)
    {

        if (isset($type)) {
            $rs = $this->model->where('type', $type)->orderBy('id', 'ASC')->get();
        } else {
            $rs = Service::select('service.*', DB::raw('(SELECT COUNT(*) FROM data WHERE data.service_id = service.id AND data.status = 1) AS count_max'))->get();
        }

        $lists = array();
        foreach ($rs as $x) {
            $lists[$x['type']][] = $x;
        }
        return $lists;
    }

    public function checkSerViceExits($id)
    {
        $service = $this->model->where('id', $id)->first();
        return isset($service) ? $service : null;
    }

    public function addService($arrData){
        $this->model->create($arrData);
        return true; 
    }
}
