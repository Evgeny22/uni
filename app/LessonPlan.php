<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasDocuments;
use App\Traits\HasActivities;
use App\Traits\HasComments;
use App\Traits\HasParticipants;
use App\Traits\HasExemplar;
use App\Contracts\RecordsActivities;
use App\Contracts\CanBeExemplar;
use App\User;

class LessonPlan extends Model implements RecordsActivities, CanBeExemplar
{
    use IsAuthored,
        HasDocuments,
        HasActivities,
        HasExemplar,
        HasComments,
        HasParticipants;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    /**
     * The attributes that are appended to the lesson plan when returned
     *
     * @var array
     */
    protected $appends = [
        'url',
        'isExemplar'
    ];



    /**
     * Bind any model events
     *
     * @return void
     */
    public static function boot()
    {
        static::deleting(function ($lessonPlan)
        {
            $lessonPlan->tags()->detach();

            
            foreach ($lessonPlan->activities as $activity) {
                $activity->delete();
            }
            
        });
    }
    
    
    /**
     * Get the URL to this lesson plan
     *
     * @return sting
     */
    public function getUrlAttribute()
    {
        return route('instructional-design.show', [
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
     * A lesson plan can have many answers
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Gets the last user that contributed an answer to this lesson plan
     *
     * @return App\User
     */
    public function getLastContributorAttribute()
    {
        return User::join('answers', 'answers.author_id', '=', 'users.id')
            ->join('lesson_plans', 'lesson_plans.id', '=', 'answers.lesson_plan_id')
            ->where('lesson_plans.id', $this->id)
            ->orderBy('answers.updated_at', 'desc')
            ->select('users.*')
            ->first();
    }

    /**
     * A lesson plan can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    /**
     * A lessonPlan can have many exemplar requests
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function exemplars()
    {
        return $this->morphMany(Exemplar::class,'exemplarable');
    }
}
