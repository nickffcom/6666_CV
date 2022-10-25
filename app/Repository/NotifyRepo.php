<?php
namespace App\Repository;

use App\Repository\BaseRepo;
use App\Models\Notify;

class NotifyRepo extends BaseRepo{
 

    public function getModel()
    {
        return Notify::class;
    }

   
  
   
}