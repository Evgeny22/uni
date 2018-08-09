<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasParticipants;
use App\Traits\HasActivities;
use App\Traits\HasComments;
use App\Traits\HasTags;
use App\Contracts\RecordsActivities;

class Message extends Model implements RecordsActivities
{
    use HasActivities,
        HasComments,
        HasParticipants,
        HasTags,
        IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'content'
    ];

    /**
     * The attributes that are appended to the message when returned
     *
     * @var array
     */
    protected $appends = [
        'url'
    ];

    /**
     * Bind any model events
     *
     * @return void
     */
    public static function boot()
    {
        static::deleting(function ($message)
        {
            foreach ($message->comments as $comment) {
                $comment->delete();
            }

            foreach ($message->activities as $activity) {
                $activity->delete();
            }
        });
    }

    /**
     * Get the URL to this message
     *
     * @return sting
     */
    public function getUrlAttribute()
    {
        return route('messages.show', [
            'id' => $this->id,
        ]);
    }

    /**
     * A message can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }
}
