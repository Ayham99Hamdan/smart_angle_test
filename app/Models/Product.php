<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'description',
        'price',
        'seller_id'
    ];

    // Relation with Seller
    public function seller(){
        return $this->belongsTo(Seller::class , 'seller_id' , 'user_id');
    }
}
