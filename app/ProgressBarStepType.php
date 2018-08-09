<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ProgressBarStepProgress;

class ProgressBarStepType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}
