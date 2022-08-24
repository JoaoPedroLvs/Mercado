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

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
