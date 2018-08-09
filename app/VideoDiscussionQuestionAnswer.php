<?php

namespace App;

use App\Traits\IsAuthored;
use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasActivities;
use App\Traits\HasParticipants;

use App\Contracts\RecordsActivities;

class VideoDiscussionQuestionAnswer extends Model implements RecordsActivities
{
    use IsAuthored,
        HasComments,
        HasParticipants,
        HasActivities;

    /**
     * The attribvutes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'video_discussion_id',
        'video_discussion_question_id',
        'question_id',
        'answer',
        'is_draft'
    ];

    public function videoDiscussion() {
        return $this->belongsTo(VideoDiscussion::class, 'video_discussion_id');
    }

    public function getUrlAttribute() {
        // TODO: Implement getUrlAttribute() method.
    }
}
