<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(['name' => 'admin','email' => 'admin@sysout.com.br', 'password' => Hash::make('sysout'), 'role' => 1]);
    }
}
