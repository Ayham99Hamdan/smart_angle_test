<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\CustomerRequests\CustomerLoginRequest;
use App\Http\Requests\CustomerRequests\CustomerRegisterRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Traits\PasswordHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    use PasswordHandlerTrait;
    // Start of Regiester
    public function register(CustomerRegisterRequest $request){
        //After validate data, Create new record

        //encryption password
        $request['password'] = $this->encryption($request->password);

        // Create User Record
        $customer = User::create($request->all());
        //Create Customer Record
        $customer->customer()->create();
        // Get a token for this user
        $token = $customer->createToken('customer' . $customer->id)->accessToken;
        // Return a success response and data 
        return $this->apiResponse(['user' => new CustomerResource($customer) , 'token' => $token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    } //end of Regirster

    //Start of Login
    public function login(CustomerLoginRequest $request){
        // get Customer form data base via email that we already check if it exists or not
        $customer = User::Has('customer')->where('email' , $request->email)->first();
        // check if password correct or not
        if(!$customer || !Hash::check($request->password, $customer->password)){
          return $this->apiResponse('' , HTTPCodesEnum::STATUS_NOT_AUTHENTICATED , "No matched credentials");
        }
        // Get a token for this user
        $token = $customer->createToken('customer' . $customer->id)->accessToken;
        // Return a success response and data 
        return $this->apiResponse(['user' => new CustomerResource($customer) , 'token' => $token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    }//end of login
}
