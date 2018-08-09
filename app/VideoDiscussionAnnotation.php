<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Annotation;

class VideoDiscussionAnnotation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discussion_id',
        'annotation_id',
    ];

    public function associatedAnnotation() {
        return $this->hasOne(Annotation::class, 'id', 'annotation_id');
    }

}
