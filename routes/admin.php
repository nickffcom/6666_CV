<?php

use App\Http\Controllers\AD\BMController;
use App\Http\Controllers\AD\CloneController;
use App\Http\Controllers\AD\ViaController;
use Illuminate\Support\Facades\Route;




//  View For admin *****************************

Route::group(['prefix'=>'admin','middleware'=>'auth'], function () {

    Route::resources([
        'via' => ViaController::class,
        'bm' => BMController::class,
        'clone' => CloneController::class,
    ]);
    Route::get('/type/via',[ViaController::class,'type']); // phân loại
    Route::get('/type/bm',[BMController::class,'type']);
    Route::get('/type/clone',[CloneController::class,'type']);





});




