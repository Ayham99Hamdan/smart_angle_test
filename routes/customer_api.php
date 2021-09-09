<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::group([], function(){
    Route::post('register', [CustomerController::class, 'register']);
    Route::post('login' , [CustomerController::class, 'login']);
});

