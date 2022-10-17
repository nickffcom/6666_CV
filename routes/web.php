<?php

use App\Http\Controllers\US\BuyController;
use App\Http\Controllers\US\HomeController;
use App\Http\Controllers\US\LoginController;
use App\Http\Controllers\US\RegisterController;
use App\Http\Controllers\US\TestController;
use Illuminate\Support\Facades\Route;


//  View For User *******************************

Route::view('/register','User.register')->name('userRegister');
Route::view('/login','User.login')->name('userLogin');
Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[LoginController::class,'login']);


Route::get('/test', [TestController::class,"index"]);




Route::middleware('auth')->group(function(){

    Route::get('/',[HomeController::class,'home']);
    Route::prefix('/api')->group(function(){
        Route::post('/buy',[BuyController::class,'BuyDataAds']);
    });
   
});





