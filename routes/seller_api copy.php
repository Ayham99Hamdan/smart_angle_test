<?php

use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::group([], function(){
    Route::post('register', [SellerController::class, 'register']);
    Route::post('login' , [SellerController::class, 'login']);
});

