<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $column, $order, $search) {

        $query->select('c.*')->from('categories as c');

        if ($search) {

            $query->whereRaw("name ilike '%".$search."%'");

        }

        $query->orderBy($column, $order);

        return $query;

    }
}
