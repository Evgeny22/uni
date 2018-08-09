<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasDocuments;
use App\Traits\HasActivities;

class LearningModule extends Model
{
    use IsAuthored,
        HasDocuments,
        HasActivities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'zoom_url',
        'wistia_id',
        'wistia_hashed_id',
        'wistia_duration',
        'wistia_thumbnail'
    ];

    /**
     * The attributes that are appended to the learning module when returned
     *
     * @var array
     */
    protected $appends = [
        'url'
    ];

    /**
     * Get the URL to this learning module
     *
     * @return sting
     */
    public function getUrlAttribute()
    {
        return route('learning-modules.show', [
            'id' => $this->id,
        ]);
    }
}
