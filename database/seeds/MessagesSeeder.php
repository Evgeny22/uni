<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Message;
use App\Comment;
use App\User;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::truncate();

        $faker = Faker::create();

        factory(Message::class, 25)->create()->each(function($message) use ($faker)
        {
            // Attach two random participants
            $message->participants()->attach([
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
                $message->comments()->attach($comment->id);
            }
        });
    }
}
