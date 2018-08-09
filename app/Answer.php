<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;

class Answer extends Model
{
    use IsAuthored;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['lessonPlan'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'author_id'
    ];

    /**
     * An answer belongs to a lesson plan
     *
     * @return Illuminate\Eloquent\Relations\BelongsTo
     */
    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
