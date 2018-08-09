<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSave extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id'
    ];

    public function object() {
        return $this->hasOne(UserSaveObject::class);
    }
}
