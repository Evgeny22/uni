<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\IsAuthored;

class Document extends Model
{
    use IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'extension',
        'path',
        'title',
        'description'
    ];

    /**
     * A document can be attached to different types of objects
     *
     * @return Illuminate\Eloquent\Relations\MorphMany
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
