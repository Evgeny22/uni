<?php

use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\School::truncate();

        App\School::create([
            'name' => 'Educare Miami'
        ]);

        App\School::create([
            'name' => 'Educare Seattle'
        ]);

        App\School::create([
            'name' => 'Educare Omaha - Kellom'
        ]);

        App\School::create([
            'name' => 'Educare Omaha - Indian Hill'
        ]);
    }
}
