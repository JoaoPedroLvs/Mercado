<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'password',
        'email',
        'cpf',
        'rg',
        'phone',
        'work_code'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function roles() {
        return $this->hasOne(EmployeeRole::class);
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function scopeSearch($query, $column, $order, $search) {

        $query->select('em.*', 'p.name', 'p.cpf')
        ->from('employees as em');

        $query->join('people as p', 'p.id', 'em.person_id');

        $query->orderBy($column, $order);

        if ($search) {

            $query->whereRaw("name ilike '%".$search."%'");

        }

        return $query;
    }

    public function scopeSearchEmployee($query, $column, $order, $id) {

        $query->select('p.*', 'em.work_code')
        ->from('employees as em')->where('em.id', $id);

        $query->join('people as p', 'p.id', 'em.person_id');

        $query->orderBy($column,$order);

        return $query;
    }
}
