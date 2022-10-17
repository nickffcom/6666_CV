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

class ServiceRepo extends BaseRepo{
 

    public function getModel()
    {
        return Service::class;
    }

    public function getServiceWeb($type = null)
    {
        $rs = Service::select('service.*', DB::raw('(SELECT COUNT(*) FROM data WHERE data.service_id = service.id AND data.status = 1) AS count_max'));
        // dd($rs->dd());
        if (isset($type)) {
            $rs = $rs->where('type', $type);
        }
        $lists = array();
        foreach ($rs->get() as $x) {
            $lists[$x['type']][] = $x;
        }
        return $lists;
    }

    public function checkSerViceExits($id)
    {
        $service = $this->model->where('id', $id)->first();
        return isset($service) ? $service : null;
    }


    
}