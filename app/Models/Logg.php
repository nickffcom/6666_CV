<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logg extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'Logg';
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
    }

  
}
