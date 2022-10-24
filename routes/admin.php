<?php

use App\Http\Controllers\AD\BMController;
use App\Http\Controllers\AD\CloneController;
use App\Http\Controllers\AD\ManageUserController;
use App\Http\Controllers\AD\ServiceController;
use App\Http\Controllers\AD\ViaController;
use Illuminate\Support\Facades\Route;




//  View For admin *****************************

Route::group(['prefix'=>'admin','middleware'=>'auth'], function () {

    Route::resources([
        'via' => ViaController::class,
        'bm' => BMController::class,
        'clone' => CloneController::class,
    ]);
    Route::get('/type/{type}',[ServiceController::class,'type']); // phân loại


    Route::post('/service/update',[ServiceController::class,"HandleService"])->name("updateService");
    Route::post('/service/add/{type}',[ServiceController::class,"addService"])->name("addService");
    Route::post('/service/delete',[ServiceController::class,"deleteService"])->name("deleteService");
    Route::post('/service/show/{id}',[ServiceController::class,"detailService"])->name("detailService");

    Route::get('/settings',[ServiceController::class,'Settings']);
    Route::get('/notify',[ServiceController::class,'notify']);
    Route::get('/thong-ke',[ServiceController::class,'ThongKeDoanhThu']);
    Route::get('/lich_su_hoat_dong',[ServiceController::class,'LichSuHoatDong']);
    

    Route::get('/trans',[ServiceController::class,'CongTruTien']);
    Route::post('/trans',[ServiceController::class,'HandleCongTruTien']);

    Route::get('/users',[ManageUserController::class,'ManageUsers']);
    Route::post('/users/detail',[ManageUserController::class,'detailUser']);



});




