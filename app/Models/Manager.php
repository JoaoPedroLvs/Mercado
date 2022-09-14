<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function user() {
        return $this->hasOne(User::class);
    }

    public function scopeSearch($query, $column, $order, $search) {

        $query->select('ma.id', 'ma.created_at', 'p.name','p.cpf')->from('managers as ma');

        $query->join('people as p', 'p.id', 'ma.person_id');

        if ($search) {

            $query->whereRaw("name ilike '%".$search."%'");
        }

        $query->orderBy($column, $order);

        return $query;

    }

    public function scopeSearchManager($query, $id) {

        $query->select('p.*')
        ->from('managers as ma')
        ->where('ma.id',$id);

        $query->join('people as p', 'p.id', 'ma.person_id');

        return $query;
    }
}
