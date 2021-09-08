<?php

namespace App\Traits;

trait PasswordHandlerTrait{

    public function encryption($password){
        return bcrypt($password);
    }
}