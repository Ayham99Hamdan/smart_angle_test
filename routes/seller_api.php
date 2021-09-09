<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::post('register', [SellerController::class, 'register']);
Route::post('login' , [SellerController::class, 'login']);

Route::middleware(['auth:api'])->group(function(){
    
    Route::apiResource('product' , ProductController::class);
});

