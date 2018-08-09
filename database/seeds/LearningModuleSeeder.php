<?php

use Illuminate\Database\Seeder;
use App\LearningModule;

class LearningModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(LearningModule::class, 10)->create();
    }
}
