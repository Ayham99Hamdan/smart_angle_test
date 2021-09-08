<?php

namespace App\Traits;

use App\Enums\HTTPCodesEnum;

trait RestfulTrait{

    // this function handel response format for api
    public function apiResponse($data = null  , $code = 200 , $message = null , $paginate = null){
        $arrayResponse = [
            'data' => $data ,
            'status' => $code == HTTPCodesEnum::STATUS_OK 
                                || $code==HTTPCodesEnum::STATUS_CREATED 
                                || $code==HTTPCodesEnum::STATUS_NO_CONTENT 
                                || $code==HTTPCodesEnum::STATUS_RESET_CONTENT  ,
            'message' => $message ,
            'code' => $code ,
            'paginate' => $paginate
        ];
        return response($arrayResponse,$code);
    }//end of apiResponse function




}