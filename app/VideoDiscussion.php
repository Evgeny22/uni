<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\VideoDiscussionQuestion;
use App\VideoDiscussionAnnotation;

use App\Traits\IsAuthored;

use App\Traits\HasActivities;
use App\Traits\HasParticipants;

use App\Contracts\RecordsActivities;

class VideoDiscussion extends Model implements RecordsActivities
{
    use IsAuthored,
        HasParticipants,
        HasActivities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'video_id',
        'column_id',
        'annotation_id',
        'title',
        'annotation'
    ];

    public function originalAnnotation() {
        return $this->hasOne(Annotation::class, 'id', 'annotation_id');
    }

    public function questions() {
        return $this->hasMany(VideoDiscussionQuestion::class);
    }

    public function video() {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }

    public function annotations() {
        return $this->hasMany(VideoDiscussionAnnotation::class, 'discussion_id');
    }

    public function getUrlAttribute() {
        //return $this->video->url;
    }
}
