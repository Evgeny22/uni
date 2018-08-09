<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoColumnObject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_column_id',
        'object_id',
        'object_type'
    ];
}
