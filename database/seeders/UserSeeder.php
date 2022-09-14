<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\Person;
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

        $manager = Manager::first();
        $user = [
            'manager_id' => $manager->id,
            'email' => 'admin@sysout.com.br',
            'password' => Hash::make('12341234')
        ];

        User::insert([$user]);
    }
}
