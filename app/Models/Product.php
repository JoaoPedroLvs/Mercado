<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function category() {

        return $this->belongsTo(Category::class);

    }

    public function inventories() {

        return $this->hasMany(Inventories::class);

    }

    public function promotions() {

        return $this->hasMany(Promotion::class);

    }

    public function sales() {

        return $this->belongsToMany(Sale::class);

    }

    public function scopeSearch($query) {

        $query->from('products as p');

        $query->leftJoin('product_sale as ps', 'ps.product_id', 'p.id');

        $query->select(
            'p.*',
            DB::raw('count(ps.id) as total_sold')
        );

        $query->groupBy('p.id');

        return $query;
    }

}
