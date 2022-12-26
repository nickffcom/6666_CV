<?php

use App\Http\Controllers\US\BuyController;
use App\Http\Controllers\US\HomeController;
use App\Http\Controllers\US\LoginController;
use App\Http\Controllers\US\OrderController;
use App\Http\Controllers\US\ProxyController;
use App\Http\Controllers\US\RegisterController;
use App\Http\Controllers\US\SocialController;
use App\Http\Controllers\US\TestController;
use Illuminate\Support\Facades\Route;

//  View For User *******************************

Route::view('/register','User.register')->name('userRegister');
Route::view('/login','User.login')->name('userLogin');
Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[LoginController::class,'login']);


Route::get('/test', [TestController::class,"index"]);




Route::middleware('auth')->group(function(){

    Route::get('/',[HomeController::class,'home'])->name('home');
    Route::prefix('/api')->group(function(){
        Route::post('/buy',[BuyController::class,'HandleBuy']);
    });

    Route::get('/order',[OrderController::class,"getviewOrder"]);
    Route::get('/order_proxy',[ProxyController::class,"getviewOrderProxyOfUser"]);
    Route::get('/order/view_order',[OrderController::class,"getViewOrderDetailByCode"]);
    Route::get('/order/download_order',[OrderController::class,"downloadOrderByCode"]);
    Route::get('/nap-tien',[HomeController::class,"napTien"]);
    Route::get('/lich-su-nap-tien',[HomeController::class,"lichSuNapTien"]);
    Route::get('/ho-tro',[HomeController::class,"Hotro"]);
    Route::get('/tai-khoan',[HomeController::class,'getTaiKhoan']);
    Route::get('/lich-su-thanh-toan',[HomeController::class,'LichSuThanhToan']);

    Route::post('/change_password',[LoginController::class,'UpdateInfoUser']);
    Route::get('/dang-xuat',[LoginController::class,'logout']);
    Route::view('/check-live_uid','User.checkLiveUid');
    Route::view('/get_code_2fa','User.get_code_2fa');


});
Route::get('/auth/delete',[SocialController::class,"delete"]);
Route::get('/auth/{type}/callback',[SocialController::class,"handleSocial"]); //->where('type',['facebook', 'google']);
Route::get('/auth/redirect/{type}',[SocialController::class,"rediRectSocial"])->name('fb');





