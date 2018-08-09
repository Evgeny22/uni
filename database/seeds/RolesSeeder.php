<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Role::truncate();

        // Parent
        DB::table('roles')->insert([
            'machine_name' => 'parent',
            'display_name' => 'Parent'
        ]);

        // Teacher
        DB::table('roles')->insert([
            'machine_name' => 'teacher',
            'display_name' => 'Teacher'
        ]);

        // Master Teacher
        DB::table('roles')->insert([
            'machine_name' => 'master_teacher',
            'display_name' => 'Master Teacher'
        ]);

        // School Leaders
        DB::table('roles')->insert([
            'machine_name' => 'school_leader',
            'display_name' => 'School Leader'
        ]);

        // Project Admin
        DB::table('roles')->insert([
            'machine_name' => 'project_admin',
            'display_name' => 'Project Admin'
        ]);

        // Super Admin
        DB::table('roles')->insert([
            'machine_name' => 'super_admin',
            'display_name' => 'Super Admin'
        ]);
    }
}
