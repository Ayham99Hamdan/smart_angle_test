<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group([], function(){
    Route::post('login' , [AdminController::class, 'login']);
});

