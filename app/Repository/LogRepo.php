<?php

namespace App\Repository;

use App\Models\Logg;
use App\Repository\BaseRepo;
use Illuminate\Support\Facades\Log;

class LogRepo extends BaseRepo
{


  public function getModel()
  {
    return Logg::class;
  }


  
}
