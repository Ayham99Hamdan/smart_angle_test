<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::post('register', [CustomerController::class, 'register']);
Route::post('login' , [CustomerController::class, 'login']);

Route::middleware('auth:api')->prefix('cart')->group(function(){
    Route::post('add' , [CartController::class , 'addToCart']);
    Route::put('edit' , [CartController::class , 'editItme']);
    Route::delete('delete' , [CartController::class , 'deleteFromCart']);
});

