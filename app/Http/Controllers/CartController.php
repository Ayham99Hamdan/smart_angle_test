<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequests\CartAddRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(CartAddRequest $request){
        $user = auth('api')->user();
        
    }
}
