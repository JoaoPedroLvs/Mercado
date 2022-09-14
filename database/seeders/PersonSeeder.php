<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = [
            'name' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Person::insert($person);
    }
}
