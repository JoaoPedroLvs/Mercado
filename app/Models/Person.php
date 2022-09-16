<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->hasOne(Employee::class);

    }

    public function customer() {
        return $this->hasOne(Customer::class);
    }

    public function manager() {
        return $this->hasOne(Manager::class);
    }

    public function scopeSearch($query, $column, $order, $search) {

        $query->select('*')
        ->from('people');

        if ($search) {

            $query->whereRaw("name ilike '%".$search."%'");
        }

        $query->orderBy($column, $order);

        return $query;
    }
}
