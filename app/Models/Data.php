<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $table="data";
    public $timestamps = true;
    // protected $fillable = ['name'];
    protected $guarded=[];
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function getattrAttribute($value){
        return json_decode($value);
    }
}
