<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function employee() {
        return $this->belongsToMany(Employee::class);
    }

    public function scopeSearch ($query, $column, $order, $search = null) {

        $query->select('er.*', DB::raw('(select count(id) from employees as em where em.role_id = er.id) as qty_employees'))
        ->from('employee_roles as er');

        if ($search) {
            $query->whereRaw("name ilike '%".$search."%'");
        }

        $query->orderBy($column, $order);

        return $query;
    }
}
