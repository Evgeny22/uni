<?php

namespace App\Traits;

use App\Comment;

trait HasComments
{
    /**
     * This object can have many comments
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

    /**
     * Get comments for this object by type
     *
     * @param string $type
     * @return Illuminate\Support\Collection
     */
    public function commentsByType($type)
    {
        return $this->comments()
            ->where('comments.type', $type);
    }
}
