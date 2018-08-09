<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasActivities;
use App\Traits\HasParticipants;
use App\Traits\IsAuthored;
use App\Contracts\RecordsActivities;

class ProgressBarStepProgress extends Model implements RecordsActivities
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
        'progress_bar_step_id',
        'participant_id',
        'completed'
    ];

    public function getUrlAttribute()
    {
        return '';
    }

    public function step() {
        return $this->belongsTo(ProgressBarStep::class, 'progress_bar_step_id');
    }
}
