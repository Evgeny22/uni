<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasActivities;
use App\Traits\HasParticipants;
use App\Traits\HasTags;
use App\Traits\HasComments;

use App\Contracts\RecordsActivities;

class ProgressBar extends Model implements RecordsActivities
{
    use IsAuthored,
        HasParticipants,
        HasTags,
        HasActivities,
        HasComments;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'author_id',
        'action_plan',
        'is_template',
        'deadline'
    ];

    /**
     * The attributes that are appended to the message when returned
     *
     * @var array
     */
    protected $appends = [
        'userComments'
    ];

    public function steps() {
        return $this->hasMany(ProgressBarStep::class)->orderBy('order', 'asc');
    }

    /**
     * A progress bar can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    public function getUrlAttribute()
    {
        return '';
    }

    /**
     * Returns only comments made in the user comments area
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserCommentsAttribute()
    {
        return $this->commentsByType('user')
            ->get();
    }
}
