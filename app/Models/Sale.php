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

    public function scopeSearch($query) {

        $query->select("ps.id", "pr.name as product", "ps.qty_sales", "ps.total_price", "c.name as client", "em.name as employee", "ps.sale_id")
        ->from("products as pr")
        ->join("products_sales as ps", "pr.id", "ps.product_id")
        ->join("sales as sa", "sa.id", "ps.sale_id")
        ->join("customers as c", "c.id", "sa.customer_id")
        ->join("employees as em", "em.id", "sa.employee_id");

        return $query;

    }

    public function scopeSearchQty($query){

        $query->select("ps.product_id", "ps.qty_sales")
        ->from("products_sales as ps")
        ->join("products as p", "p.id", "ps.product_id");
    }

}
