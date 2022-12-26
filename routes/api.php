<?php

use App\Http\Controllers\US\BuyController;
use App\Http\Controllers\US\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {  // api sancutum


    Route::get('/user/detail',[HomeController::class,'index']);
    Route::get('delete/token/xxx',function(Request $request){
        $request->user()->tokens()->delete(); // delete all token
        $request->user()->currentAccessToken()->delete(); //  delete token current
        // $user->tokens()->where('id', $tokenId)->delete();  // token id cụ thể
    });


});




