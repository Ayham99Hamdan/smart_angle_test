<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\SellerRequests\SellerLoginRequest;
use App\Http\Requests\SellerRequests\SellerRegisterRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\SellerResource;
use App\Models\User;
use App\Traits\PasswordHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    use PasswordHandlerTrait;
    // Start of Regiester
    public function register(SellerRegisterRequest $request){
        //After validate data, Create new record

        //encryption password
        $request['password'] = $this->encryption($request->password);

        // Create User Record
        $seller = User::create($request->all());
        //Create Customer Record
        $seller->seller()->create();
        // Get a token for this user
        $token = $seller->createToken('seller' . $seller->id)->accessToken;
        // Return a success response and data 
        return $this->apiResponse(['user' => new SellerResource($seller) , 'token' => $token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    } //end of Regirster

    //Start of Login
    public function login(SellerLoginRequest $request){
        // get seller form data base via email that we already check if it exists or not
        $seller = User::Has('seller')->where('email' , $request->email)->first();
        // check if password correct or not
        if(!$seller || !Hash::check($request->password, $seller->password)){
          return $this->apiResponse('' , HTTPCodesEnum::STATUS_NOT_AUTHENTICATED , "No matched credentials");
        }
        // Get a token for this user
        $token = $seller->createToken('seller' . $seller->id)->accessToken;
        // Return a success response and data 
        return $this->apiResponse(['user' => new SellerResource($seller) , 'token' => $token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    }//end of login
}
