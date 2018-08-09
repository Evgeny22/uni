<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\IsAuthored;
use App\Traits\HasActivities;
use App\Traits\HasParticipants;

use App\Contracts\RecordsActivities;

class VideoDeleted extends Model implements RecordsActivities
{
    use IsAuthored,
        HasParticipants,
        HasActivities;

    public function getUrlAttribute() {}
}
