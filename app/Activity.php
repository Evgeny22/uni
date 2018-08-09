<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Contracts\RecordsActivities;
use Auth;

class Activity extends Model
{
    use IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'context'
    ];

    /**
     * The attributes that should be appended when returning this activity
     *
     * @var array
     */
    protected $appends = [
        'title'
    ];

    /**
     * An activity can be recorded about many different types of objects
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function activitied()
    {
        return $this->morphTo();
    }

    /**
     * Returns a rendered view of this activity
     *
     * @return string
     */
    public function render()
    {
        switch ($this->activitied_type) {
            case Message::class:
                return view('partials.activities.message', [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case Video::class:
                if ($this->context == 'deleted') {
                    return view('partials.activities.video-deleted', [
                        'activity' => $this,
                        'user' => Auth::user()
                    ]);
                } else {
                    return view('partials.activities.video', [
                        'activity' => $this,
                        'user' => Auth::user()
                    ]);
                }
            case VideoDiscussion::class:
                return view('partials.activities.video-discussion', [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case VideoDiscussionQuestionAnswer::class:
                return view('partials.activities.video-discussion-'. $this->context, [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case LessonPlan::class:
                return view('partials.activities.lesson', [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case UserShare::class:
                return view('partials.activities.user-share', [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case ProgressBar::class:
                return view('partials.activities.progress-bar-'. $this->context, [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case ProgressBarStep::class:
                return view('partials.activities.progress-bar-step-'. $this->context, [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
            case ProgressBarStepProgress::class:
                return view('partials.activities.progress-bar-step-'. $this->context, [
                    'activity' => $this,
                    'user' => Auth::user()
                ]);
        }
    }
}
