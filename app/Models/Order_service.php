<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_service extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded=[];
    protected $table = 'order_service';
    public function user(){
        return $this->belongsTo(User::class);
    }
}
