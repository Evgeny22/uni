<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserSave;

class UserSaveObject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_save_id',
        'object_id',
        'object_type',
    ];

    public function userSave() {
        return $this->belongsTo(UserSave::class);
    }
}
