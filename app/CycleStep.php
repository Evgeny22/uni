<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CycleStep extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cycle_id',
        'object_id',
        'object_type',
        'type'
    ];

    public function progress() {
        return $this->hasManyThrough(Cycle::class,CycleProgress::class);
    }
}
