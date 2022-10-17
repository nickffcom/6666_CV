<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;
    protected $table = 'service';
    protected $guarded=[];
    public $timestamps = true;


    public function data()
    {
        return $this->hasMany(Data::class);
    }


// ********************************************
 
  
}
