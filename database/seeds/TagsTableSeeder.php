<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::truncate();

        // Crosscutting concepts
        DB::table('tags')->insert([
            'tag' =>'Patterns',
            'type' => 'Crosscutting Concepts'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Cause and Effect',
            'type' => 'Crosscutting Concepts'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Scale Proportion and Quantity',
            'type' => 'Crosscutting Concepts'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Systems and System Models',
            'type' => 'Crosscutting Concepts'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Structure and Function',
            'type' => 'Crosscutting Concepts'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Stability and Change',
            'type' => 'Crosscutting Concepts'
        ]);

        //Practices
        DB::table('tags')->insert([
            'tag' =>'Making Observations',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Asking Questions and Defining Problems',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Making Predictions',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Developing and Using Models',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Planning and Carrying Out Investigations',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Using Math and Computational Thinking',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Documenting Analyzing and Interpreting Data',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Constructing Explanations and Designing Solutions',
            'type' => 'Practices'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Communicating Information',
            'type' => 'Practices'
        ]);

        //Core ideas
        DB::table('tags')->insert([
            'tag' =>'Physical Science',
            'type' => 'Core Ideas'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Life Science',
            'type' => 'Core Ideas'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Earth and Space Science',
            'type' => 'Core Ideas'
        ]);
        DB::table('tags')->insert([
            'tag' =>'Engineering, Technology and the Applications of Science',
            'type' => 'Core Ideas'
        ]);

    }
}
