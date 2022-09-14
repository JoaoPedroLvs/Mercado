<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\Person;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = Person::first();

        $manager = new Manager();

        $manager->person_id = $person->id;

        $manager->save();
    }
}
