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

        $query->leftJoin('promotions as pm', 'pm.product_id', DB::raw('p.id and pm.is_active = true'));

        // $query->where('pm.is_active', 'true');

        $query->select(
            'p.*',
            'pm.price as promotion'
        );

        return $query;
    }

}
