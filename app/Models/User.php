<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function customer() {
        return $this->hasOne(Customer::class);
    }

    public function employee() {
        return $this->hasOne(Employee::class);
    }
    // private $roles = [
    //     1 => ['customer.index', 'customer.insert', 'customer.update'],
    //     2 => ['employer.index', 'employer.insert']
    // ];

    // $group = $user->group;

    // $group->hasPermission("customer.index");
    // $roles = $this->roles[$this->id]


    // if (in_array($role, $roles)) {
    //     return true;
    // } else {
    //     return false;
    // }
}
