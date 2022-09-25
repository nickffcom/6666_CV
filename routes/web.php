<?php

use Illuminate\Support\Facades\Route;


//  View For User *******************************
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home',function(){
    return view('User.home');
});