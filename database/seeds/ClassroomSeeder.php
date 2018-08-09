<?php

use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Classroom::truncate();

        $classes = [
            'English',
            'Math',
            'Biology',
            'Physics',
            'Chemistry',
            'French',
            'German',
            'IT',
            'Business',
            'Gym',
            'Latin'
        ];

        for ($i = 0; $i < 10; $i++) {
            App\Classroom::create([
                'name' => $classes[$i],
                'school_id' => rand(1, 4)
            ]);
        }
    }
}
