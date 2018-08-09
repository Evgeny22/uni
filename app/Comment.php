<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasActivities;
use App\Contracts\RecordsActivities;
use App\VideoDiscussionQuestion;

class Comment extends Model implements RecordsActivities
{
    use IsAuthored,
        HasActivities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'approved',
        'content',
        'type',
        'comment_date',
        'parent_id'
    ];

    /**
     * Comments can be left on many messages
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOneOrMany
     */
    public function messages()
    {
        return $this->morphedByMany(Message::class, 'commentable');
    }

    /**
     * Comments can be left on many videos
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'commentable');
    }

    /**
     * Comments can be left on many discussion questions
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function videoDiscussionQuestionAnswers()
    {
        return $this->morphedByMany(VideoDiscussionQuestionAnswer::class, 'commentable');
    }

    /**
     * Get the URL to this message
     *
     * @return sting
     */
    public function getUrlAttribute()
    {
        return $this->commentable->url;
    }

    /**
     * A comment can have one level deep of "subcomments"
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subComments() {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
