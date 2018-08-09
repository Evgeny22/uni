<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserShare;
use App\Traits\IsAuthored;
use App\Traits\HasActivities;
use App\Traits\HasParticipants;

use App\Contracts\RecordsActivities;

class UserShareObject extends Model implements RecordsActivities
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
        'user_share_id',
        'object_id',
        'object_type',
    ];

    public function userShare() {
        return $this->belongsTo(UserShare::class);
    }

    public function data() {
        switch ($this->object_type) {
            case Video::class:
                return $this->belongsTo(Video::class, 'object_id');

            case ProgressBar::class:
                return $this->belongsTo(ProgressBar::class, 'object_id');
        }
    }

    public function getUrlAttribute() {
        // TODO: Implement getUrlAttribute() method.
    }
}
