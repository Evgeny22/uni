<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'nickname' => $faker->name,
        'email' => $faker->email,
        'bio' => $faker->sentence,
        'password' => bcrypt('demo'),
        'role_id' => $faker->numberBetween(1, 6),
        'classroom_id' => $faker->numberBetween(1, 10)
    ];
});

$factory->defineAs(App\User::class, 'super_admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'super_admin@esi.dev',
        'name' => 'Super Admin',
        'role_id' => 6
    ]);
});

$factory->defineAs(App\User::class, 'project_admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'project_admin@esi.dev',
        'name' => 'Project Admin',
        'role_id' => 5
    ]);
});

$factory->defineAs(App\User::class, 'school_leader', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'school_leader@esi.dev',
        'name' => 'School Leader',
        'role_id' => 4
    ]);
});

$factory->defineAs(App\User::class, 'master_teacher', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'master_teacher@esi.dev',
        'name' => 'Master Teacher',
        'role_id' => 3
    ]);
});

$factory->defineAs(App\User::class, 'teacher', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'teacher@esi.dev',
        'name' => 'Teacher',
        'role_id' => 2
    ]);
});

$factory->defineAs(App\User::class, 'parent', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);
    return array_merge($user, [
        'email' => 'parent@esi.dev',
        'name' => 'Parent',
        'role_id' => 1
    ]);
});

$factory->define(App\School::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\LearningModule::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph(1),
        'author_id' => rand(1, 11)
    ];
});

$factory->define(App\Activity::class, function (Faker\Generator $faker) {
    return [
        'author_id' => 0,
        'object_id' => 0,
        'action' => $faker->randomElement([
            'posted',
            'uploaded',
        ]),
        'component_type' => $faker->randomElement([
            'messages',
            'resources',
            'comments',
        ]),
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->paragraph(1),
        'content' => $faker->sentence,
        'author_id' => rand(1, 11)
    ];
});

$factory->define(App\LessonPlan::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph(1),
        'author_id' => rand(1, 11)
    ];
});

$factory->define(App\Video::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->paragraph(1),
        'author_id' => rand(1, 11),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker)
{
    return [
        'content' => $faker->paragraph(1),
        'author_id' => $faker->randomElement(App\User::all()->lists('id')->toArray()),
        'approved' => $faker->randomElement([0, 1])
    ];
});
