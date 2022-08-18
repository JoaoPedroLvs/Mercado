<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'started_at',
        'ended_at',
        'is_active'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function product(){

        return $this->belongsTo(Product::class);

    }

    public function scopeSearchPrice($query){

        $query->select("pd.price as product", "pm.price as promotion", "pm.is_active")
        ->from("products as pd")
        ->leftJoin("promotions as pm", "pd.id", DB::raw("pm.product_id and pm.is_active = true"));

        return $query;

    }
}
