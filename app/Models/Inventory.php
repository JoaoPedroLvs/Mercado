<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function scopeSearch($query, $column, $order, $search) {
        $query->select('in.*', 'pr.name')
        ->from('inventories as in');

        $query->join('products as pr', 'pr.id', 'in.product_id');

        if ($search) {
            $query->whereRaw("name ilike '%".$search."%'");
        }

        $query->orderBy($column,$order);

        return $query;
    }
}
