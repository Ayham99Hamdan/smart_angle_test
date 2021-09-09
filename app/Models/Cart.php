<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity'
    ];

    protected $appends = ['value'];

    public function customers(){
        return $this->hasMany(Customer::class, 'user_id' , 'customer_id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'id' , 'product_id');
    }

    public function getValueAttribute(){
        return $this->quantity * $this->products->first()->price;
    }
}
