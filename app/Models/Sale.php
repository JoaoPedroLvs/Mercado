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

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function products() {

        return $this->belongsToMany(Product::class);

    }


    public function scopeSearch($query, $id) {

        $query->select('ps.id', 'pr.name as product', 'ps.qty_sales', 'ps.total_price', 'p.name as client', 'ps.sale_id', 'pr.price', 's.total_no_promotion')
        ->from('sales as s');

        $query->join('product_sale as ps', 'ps.sale_id', 's.id');

        $query->join('products as pr', 'pr.id', 'ps.product_id');

        $query->join('customers as c', 'c.id', 's.customer_id');

        $query->join('people as p', 'p.id', 'c.person_id');

        $query->leftJoin('promotions as pm', 'pm.product_id', 'pr.id');

        $query->where('ps.sale_id', $id);

        return $query;

    }

    public function scopeSearchQty($query, $id) {

        $query->select("ps.product_id", "ps.qty_sales")
        ->from("product_sale as ps")
        ->join("products as p", "p.id", "ps.product_id")
        ->where("ps.sale_id", $id);

        return $query;
    }

}
