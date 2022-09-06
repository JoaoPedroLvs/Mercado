<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'rg',
        'cpf',
        'phone'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
