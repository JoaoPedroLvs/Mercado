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
        return $this->hasOne(User::class);
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function scopeSearch($query, $column, $order, $search) {

        $query->select('c.*', 'p.name', 'p.cpf')
        ->from('customers as c');

        $query->join('people as p', 'p.id', 'c.person_id');

        if ($search) {

            $query->whereRaw("name ilike '%".$search."%'");

        }

        $query->orderBy($column,$order);

        return $query;
    }

    public function scopeSearchCustomer($query, $id) {

        $query->select('p.*')
        ->from('customers as c')
        ->where('c.id', $id);

        $query->join('people as p', 'p.id', 'c.person_id');

        return $query;
    }
}
