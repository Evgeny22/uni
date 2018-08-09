<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Video;
use Illuminate\Support\Facades\Auth;

class Exemplar extends Model
{
    use IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason',
        'rejected_reason',
        'author_id',
        'approved',
        'approver_id'
    ];

    /**
     * An exemplar can be attached to different types of objects
     *
     * @return Illuminate\Eloquent\Relations\MorphMany
     */
    public function exemplarable()
    {
        return $this->morphTo();
    }

    /**
     * Returns a rendered view of this exemplar
     *
     * @return string
     */
    public function render()
    {
        switch ($this->exemplarable_type) {
            case Video::class:
                return view('partials.exemplars.video', [
                    'exemplar' => $this,
                    'user' => Auth::user()
                ]);
            break;

            case LessonPlan::class:
                return view('partials.exemplars.lesson', [
                    'exemplar' => $this,
                    'user' => Auth::user()
                ]);
            break;
        }
    }
    
}
