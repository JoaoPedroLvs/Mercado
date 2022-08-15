<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total'
    ];

    public function products(){

        return $this->belongsToMany(Product::class);

    }

    public function products_sale(){

        return $this->hasMany(ProductsSale::class);

    }
}
