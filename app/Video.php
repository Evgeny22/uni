<?php

namespace App;

use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasDocuments;
use App\Traits\HasParticipants;
use App\Traits\HasActivities;
use App\Traits\HasComments;
use App\Traits\HasExemplar;
use App\Traits\IsShareable;
use App\Contracts\RecordsActivities;
use App\Contracts\CanBeExemplar;

class Video extends Model implements RecordsActivities, CanBeExemplar
{
    use HasActivities,
        HasDocuments,
        HasComments,
        HasParticipants,
        HasExemplar,
        HasTags,
        IsAuthored,
        IsShareable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'wistia_id',
        'wistia_hashed_id',
        'wistia_duration',
        'wistia_thumbnail',
        'hidden',
        'author_id',
        'cat_id'
    ];

    /**
     * The attributes that are appended to the message when returned
     *
     * @var array
     */
    protected $appends = [
        'url',
        'isExemplar',
        'userComments',
        'adminComments'
    ];

    /**
     * A video has many annotations
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function annotations()
    {
        return $this->hasMany(Annotation::class);
    }

    /**
     * Bind any model events
     *
     * @return void
     */
    public static function boot()
    {
        static::deleting(function ($video)
        {
            foreach ($video->comments as $comment) {
                $comment->delete();
            }

            foreach ($video->activities as $activity) {
                $activity->delete();
            }

            $video->tags()->detach();
        });
    }

    /**
     * Get the URL to this message
     *
     * @return sting
     */
    public function getUrlAttribute()
    {
        return route('video-center.show', [
            'id' => $this->id,
        ]);
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

    /**
     * Returns only comments made in the admin comments area
     *
     * @return Illuminate\Supports\Collection
     */
    public function getAdminCommentsAttribute()
    {
        return $this->commentsByType('admin')
            ->get();
    }

    /**
     * A video can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    /**
     * A video can have many exemplar requests
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function exemplars()
    {
        return $this->morphMany(Exemplar::class,'exemplarable');
    }
}
