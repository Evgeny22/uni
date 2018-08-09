<?php

use Illuminate\Database\Seeder;
use App\ResourceType;

class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResourceType::truncate();

        DB::table('resource_types')->insert([
            'type' =>'infants',
            'category' => 'families'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'toddlers',
            'category' => 'families'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'preschoolers',
            'category' => 'families'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'infants',
            'category' => 'school leaders'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'toddlers',
            'category' => 'school leaders'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'preschoolers',
            'category' => 'school leaders'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'infants',
            'category' => 'educators'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'toddlers',
            'category' => 'educators'
        ]);
        DB::table('resource_types')->insert([
            'type' =>'preschoolers',
            'category' => 'educators'
        ]);
    }
}
