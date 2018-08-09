<?php

namespace App;

use App\Traits\HasDocuments;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IsAuthored;
use App\Traits\HasTags;
use App\Traits\HasComments;

use App\User;

class Resource extends Model
{
    use IsAuthored,
        HasTags,
        HasDocuments,
        HasComments;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'remote_url',
        'resource_category_id',
        'resource_type_id',
        'is_private'
    ];

    /**
     * The attributes that are appended to the message when returned
     *
     * @var array
     */
    protected $appends = [
        'userComments'
    ];

    /**
     * A Resource has many ResourceType
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function resource_types()
    {
        return $this->belongsToMany(ResourceType::class,'resourceables');
    }

    /**
     * A Resource has one document
     *
     * @return string Document Path
     */
    public function document_path()
    {
        if ($this->documents->count() > 0) {
            return $this->documents()->first()->path;
        } else {
            return '';
        }
    }

    public function category() {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    /**
     * A resource can have many tags
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    /**
     * Returns only comments made in the user comments area
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserCommentsAttribute()
    {
        return $this->commentsByType('user')
            ->get();
    }
}
