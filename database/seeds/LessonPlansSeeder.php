<?php

use Illuminate\Database\Seeder;
use App\LessonPlan;
use App\Comment;
use App\User;
use Faker\Factory as Faker;

class LessonPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LessonPlan::truncate();

        $faker = Faker::create();

        factory(LessonPlan::class, 10)->create()->each(function($lessonPlan) use ($faker)
        {
            // Attach two random participants
            $lessonPlan->participants()->attach([
                rand(1, 5),
                rand(6, 11)
            ]);

            for ($i = 0; $i < 2; $i++) {

                $comment = Comment::create([
                    'content' => $faker->paragraph(1),
                    'author_id' => $faker->randomElement(User::all()->lists('id')->toArray()),
                    'approved' => $faker->randomElement([0, 1])
                ]);

                // Attach two new comments
                $lessonPlan->comments()->attach($comment->id);
            }
        });
    }
}
