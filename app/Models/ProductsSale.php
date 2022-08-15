<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty_sales',
        'total_price'
    ];

    public function scopeSearch($query) {

        $query->select("ps.id", "pr.name", "ps.qty_sales", "ps.total_price", 'ps.sale_id')
        ->from("products as pr")
        ->join("products_sales as ps", "pr.id", "ps.product_id");

    }
}
