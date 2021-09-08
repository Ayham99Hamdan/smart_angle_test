<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\CustomerResgisteRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Traits\PasswordHandlerTrait;
use Illuminate\Http\Request;


class CustomerController extends Controller
{

    use PasswordHandlerTrait;

    public function register(CustomerResgisteRequest $request){
        //After validate data, Create new record

        //encryption password
        $request->password = $this->encryption($request->password);

        $customer = User::create($request->all());

        $token = $customer->createToken('customer' . $customer->id)->accessToken;
        return $this->apiResponse([new CustomerResource($customer) , 'token' => $token->token],HTTPCodesEnum::STATUS_CREATED,"response successfully");
    }
}
