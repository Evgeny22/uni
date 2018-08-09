<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\IsAuthored;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag',
        'type'
    ];

    /**
     * tags can be left on many videos
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOneOrMany
     */
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'tagable');
    }

    public function messages()
    {
        return $this->morphedByMany(Message::class, 'tagable');
    }

    public function progressBars() {
        return $this->morphedByMany(ProgressBar::class, 'tagable');
    }

    public function resources() {
        return $this->morphedByMany(Resource::class, 'tagable');
    }

    /**
     * tags can be left on many instructional designs
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOneOrMany
     */
    public function lessonPlans()
    {
        return $this->morphedByMany(LessonPlan::class, 'tagable');
    }
}
