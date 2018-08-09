<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Annotation;
use Illuminate\Support\Facades\Auth;

class VideoColumn extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id',
        'author_id',
        'name',
        'color'
    ];

    public function objects() {
        return $this->hasMany(VideoColumnObject::class);
    }

}
