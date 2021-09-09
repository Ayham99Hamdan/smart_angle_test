<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;   

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(){
        return $this->first_name . " " . $this->last_name;
    }
    // Relation with Customer Table
    public function customer(){
        return $this->hasOne(Customer::class , 'user_id');
    }
    // Relation with Seller Table
    public function seller(){
        return $this->hasOne(Seller::class , 'user_id');
    }
    //Relation with Admin Table
    public function admin(){
        return $this->hasOne(Admin::class, 'user_id');
    }
}
