<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\IsAuthored;
use App\Traits\HasActivities;
use App\Traits\HasParticipants;

use App\Contracts\RecordsActivities;

class UserShare extends Model implements RecordsActivities
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
        'recipient_id'
    ];

    public function object() {
        return $this->hasOne(UserShareObject::class);
    }

    public function getUrlAttribute()
    {
        return '';
    }
}
