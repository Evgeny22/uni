<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ProgressBarStepProgress;

use App\Traits\HasActivities;
use App\Traits\HasParticipants;
use App\Traits\IsAuthored;
use App\Contracts\RecordsActivities;

class ProgressBarStep extends Model implements RecordsActivities
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
        'progress_bar_id',
        'author_id',
        'name',
        'link',
        'order',
        'due_date',
        'type_id',
        'desc',
        'participant_id',
        'is_external',
        'due_date_notified'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'due_date'
    ];

    public function progressBar() {
        return $this->belongsTo(ProgressBar::class);
    }

    public function progress() {
        return $this->hasOne(ProgressBarStepProgress::class);
    }

    public function latestProgress() {
        return $this->hasOne(ProgressBarStepProgress::class)->orderBy('created_at', 'desc');
    }

    public function usersProgress() {
        return $this->hasMany(ProgressBarStepProgress::class, 'progress_bar_step_id', 'id');
    }

    public function type() {
        return $this->hasOne(ProgressBarStepType::class, 'id', 'type_id');
    }

    public function participant() {
        return $this->hasOne(User::class, 'id', 'participant_id');
    }

    public function getUrlAttribute()
    {
        return $this->url;
        //return '';
    }
}
