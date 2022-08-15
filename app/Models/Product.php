<?php

namespace App\Models;

use GuzzleHttp\Promise\Promise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    public function category(){

        return $this->belongsTo(Category::class);

    }

    public function inventories(){

        return $this->hasMany(Inventories::class);

    }

    public function promotions(){

        return $this->hasMany(Promotion::class);

    }

    public function products_sale(){

        return $this->hasMany(ProductsSale::class);

    }
}
