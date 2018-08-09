<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use App\Traits\HasParticipants;

class Cycle extends Model
{
    use HasParticipants,
        HasTags;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'author_id',
        'color'
    ];

    public function steps() {
        return $this->hasMany(CycleStep::class);
    }

    /**
     * A cycle can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }
}
