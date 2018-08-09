<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Activity;
use App\Video;
use App\Comment;
use App\User;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::truncate();

        $faker = Faker::create();

        factory(Video::class, 25)->create()->each(function($video) use ($faker)
        {
            // Attach two random participants
            $video->participants()->attach([
                rand(1, 5),
                rand(6, 11)
            ]);

            for ($i = 0; $i < 2; $i++) {

                $comment = Comment::create([
                    'content' => $faker->paragraph(1),
                    'author_id' => $faker->randomElement(App\User::all()->lists('id')->toArray()),
                    'approved' => $faker->randomElement([0, 1])
                ]);

                // Attach two new comments
                $video->comments()->attach($comment->id);
            }
        });
    }
}
