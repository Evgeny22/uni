<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\UserShare;
use App\UserShareObject;

trait IsShareable
{
    /**
     * A shared object has just one recipient
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }
}
