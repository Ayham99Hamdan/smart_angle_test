<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\AdminRequests\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
     //Start of Login
     public function login(AdminLoginRequest $request){
        // get Admin form data base via email that we already check if it exists or not
        $admin = User::Has('admin')->where('email' , $request->email)->first();
        // check if password correct or not
        if(!$admin || !Hash::check($request->password, $admin->password)){
          return $this->apiResponse('' , HTTPCodesEnum::STATUS_NOT_AUTHENTICATED , "No matched credentials");
        }
        // Get a token for this user
        $token = $admin->createToken('admin' . $admin->id)->accessToken;
        // Return a success response and data 
        return $this->apiResponse(['user' => new AdminResource($admin) , 'token' => $token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    }//end of login
}
