<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;

class DeleteRequest extends Model
{
    use IsAuthored;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'object_id',
        'object_type'
    ];
}
