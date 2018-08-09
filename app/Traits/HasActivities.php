<?php

namespace App\Traits;

use App\Activity;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Message;
use App\Video;
use App\VideoDiscussion;
use App\VideoDiscussionQuestion;
use App\VideoDiscussionQuestionAnswer;
use App\LessonPlan;
use App\UserShare;
use App\ProgressBar;
use App\ProgressBarStep;
use App\ProgressBarStepProgress;

use Illuminate\View\View;

trait HasActivities
{
    /**
     * An object can have many activities recorded about it
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitied')
            ->orderBy('activities.created_at', 'DESC');
    }

    /**
     * Records an activity for this object
     *
     * @return void
     */
    public function record($context = '')
    {
        $authorId = isSet($this->author) ? $this->author->id : $this->participant_id;

        // Fetch author and/or recipient user profiles
        $author = isSet($this->author) ? User::where('id', $authorId)->get() : collect([]);

        // Create activity in database
        $activity = $this->activities()->save(new Activity([
            'author_id' => $authorId,
            'context' => $context
        ]));

        // Fetch newly created activity
        $activityRecord = Activity::with('activitied')
        ->leftJoin('userables', function ($join) {
            $join->on('userables.userable_id', '=', 'activities.activitied_id')
                ->on('userables.userable_type', '=', 'activities.activitied_type');
        })->where('id', $activity->id)
            ->where('userables.user_id', '!=', $authorId)
            ->get();

        // Determine what email template to use
        $template = 'emails.notifications.general';

        switch ($activity->activitied_type) {
            case Message::class:
                $template = 'emails.notifications.message';
            break;

            case Video::class:
                if ($activity->context != 'deleted') {
                    $template = 'emails.notifications.video';
                } else {
                    $template = 'emails.notifications.video-deleted';
                }
            break;

            case VideoDiscussion::class:
                $template = 'emails.notifications.video-discussion';
            break;

            case VideoDiscussionQuestionAnswer::class:
                $template = 'emails.notifications.video-discussion-'. $activity->context;
            break;

            case LessonPlan::class:
                $template = 'emails.notifications.lesson';
            break;

            case UserShare::class:
                $template = 'emails.notifications.user-share';
            break;

            case ProgressBar::class:
                $template = 'emails.notifications.progress-bar-'. $activity->context;
            break;

            case ProgressBarStep::class:
                $template = 'emails.notifications.progress-bar-step-'. $activity->context;
            break;

            case ProgressBarStepProgress::class:
                $template = 'emails.notifications.progress-bar-step-'. $activity->context;
            break;
        }

        // Fetch recipient(s)

        // Remove the "author"
        $recipients = $activityRecord->filter(function($value, $key) use ($authorId) {
            if ($value->user_id == $authorId) {
                return false;
            } else {
                return true;
            }
        });

        if (count($recipients)) {
            foreach ($recipients as $recipient) {
                $user = User::where('id', $recipient->user_id)->first();

                $view = view($template, [
                    'user' => $user,
                    'activity' => $activity
                ]);
                $body = $view->render();

                Mail::send($template, ['user' => $user, 'activity' => $activity], function ($m) use ($user) {
                    //$m->from('hello@app.com', 'Your Application');

                    $m->to($user->email, $user->name)->subject('You have a new notification!');
                });
            }
        }
    }
}
