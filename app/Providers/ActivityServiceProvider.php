<?php

namespace App\Providers;

use App\LessonPlan;
use App\VideoDiscussion;
use Illuminate\Support\ServiceProvider;
use App\Activity;
use App\Message;
use App\Comment;
use App\Video;
use App\VideoDeleted;
use App\UserShare;

class ActivityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Message::created(function($message)
        {
            $message->record();
        });

        Video::created(function($video)
        {
            $video->record();
        });

        /*VideoDiscussion::created(function($videoDiscussion)
        {
            $videoDiscussion->record();
        });*/

        /*VideoDeleted::created(function($videoDeleted)
        {
            $videoDeleted->record();
        });*/

        /*Video::deleted(function($video)
        {
            $video->record('deleted');
        });*/

        LessonPlan::created(function($lessonPlan)
        {
            $lessonPlan->record();
        });

        UserShare::created(function($userShare)
        {
            $userShare->record();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
