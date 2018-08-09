<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VideoDiscussionQuestionAnswer;

use App\Traits\IsAuthored;

class VideoDiscussionQuestion extends Model
{
    use IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'video_id',
        'video_discussion_id',
        'column_id',
        'annotation_id',
        'discussion_id',
        'question',
    ];

    public function answers() {
        return $this->hasMany(VideoDiscussionQuestionAnswer::class);
    }

    /*public function allAnswers() {
        return $this->hasMany(VideoDiscussionQuestionAnswer::class);
    }*/
}
