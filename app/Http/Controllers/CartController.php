<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\CartRequests\CartAddRequest;
use App\Http\Requests\CartRequests\CartCheckoutRequest;
use App\Http\Requests\CartRequests\CartEditRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(CartAddRequest $request){
        //get this authenticated user
        $user = auth('api')->user();
        // check if user is seller or not
        if(!$user->customer()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        $cart = Cart::where('customer_id' , $user->id)->where('product_id' , $request->product_id)->first();
        // check if record is already exists then we have to update quantity only
        if($cart){
            $cart->quantity += $request->quantity;
            $cart->save();
            return $this->apiResponse(new CartResource($cart->load('products')), HTTPCodesEnum::STATUS_CREATED, "Created Successfully");
        }
        // create a cart record
        $cart = Cart::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'customer_id' => $user->id
        ]);
        // return successfully response
        return $this->apiResponse(new CartResource($cart->load('products')), HTTPCodesEnum::STATUS_CREATED, "Created Successfully");
    }

    public function editItem(CartEditRequest $request , $id){
        //get this authenticated user
        $user = auth('api')->user();
        // check if user is seller or not
        if(!$user->customer()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        // Update record
        $cart = Cart::find($id);
        $cart->quantity += $request->quantity;
        $cart->save();
        // check if quantity is 0
        if($cart->quantity == 0){
            $cart->delete();
            return $this->apiResponse('', HTTPCodesEnum::STATUS_OK, 'Deleted Successfully');
        }
        // return successfully response
        return $this->apiResponse(new CartResource($cart->load('products')), HTTPCodesEnum::STATUS_OK, "Updated Successfully");
    }


    public function deleteFromCart($id){
        //get this authenticated user
        $user = auth('api')->user();
        // check if user is seller or not
        if(!$user->customer()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }

        $cart = Cart::find($id);
        if($cart == null){
            return $this->apiResponse('', HTTPCodesEnum::STATUS_NOT_FOUND, 'There are no Data');
        }
        // Delete record
        $cart->delete();
        // return successfully response
        return $this->apiResponse('', HTTPCodesEnum::STATUS_OK, 'Deleted Successfully');
    }

    public function checkout(CartCheckoutRequest $request, $id){
        $cart = Cart::find($id);
        if($cart == null){
            return $this->apiResponse('', HTTPCodesEnum::STATUS_NOT_FOUND, 'There are no Data');
        }
        if($request->paid_amount >= $cart->value){
            $cart->delete();
            return $this->apiResponse('' , HTTPCodesEnum::STATUS_OK , 'paid proccess completed');
        } else {
            return $this->apiResponse(new CartResource($cart) , HTTPCodesEnum::STATUS_OK , 'paid amount not enough');
        }
    }


}
