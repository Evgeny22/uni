<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesSeeder::class);
        $this->call(SchoolSeeder::class);
        //$this->call(ClassroomSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(MessagesSeeder::class);
        $this->call(VideosSeeder::class);
        $this->call(LessonPlansSeeder::class);
        $this->call(LearningModuleSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ResourceTypeSeeder::class);

        Model::reguard();
    }
}
