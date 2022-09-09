<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'phone',
        'address',
        'gender'
    ];

    public function employee() {
        return $this->hasMany(Employee::class);

    }

    public function customer() {
        return $this->hasMany(Customer::class);
    }

    public function manager() {
        return $this->hasMany(Manager::class);
    }

}
