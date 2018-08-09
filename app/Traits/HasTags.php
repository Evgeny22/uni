<?php

namespace App\Traits;

use App\Tag;
use App\Video;

trait HasTags
{
    
    /**
     * A video has just one user author
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    /**
     * Scopes the query to find objects where the title or author name matches
     * and at least have one of the tags sent selected
     * a search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTitleOrAuthorOrTag($query, $search)
    {
        return $query->where(function($q) use ($search)
        {
            $q->whereHas('author', function($q) use ($search)
            {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('nickname', 'LIKE', "%$search%");
            })->orWhereHas('tag', function($q) use ($search)
            {
                $tags = explode(',',$search);
                foreach ($tags as $tag)
                {
                    $q->where('tag','LIKE',"%$tag%" );
                }

            })->orWhere('title', 'LIKE', "%$search%");
        });
    }
}
