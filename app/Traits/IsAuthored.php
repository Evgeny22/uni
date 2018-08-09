<?php

namespace App\Traits;

use App\User;

trait IsAuthored
{
    /**
     * A message has just one user author
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Convenience method for checking if this object is authored by the user
     *
     * @param App\User $user
     * @return bool
     */
    public function isAuthoredBy(User $user)
    {
        return $this->author_id == $user->id;
    }

    /**
     * Scopes the query to find objects where the title or author name matches
     * a search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTitleOrAuthor($query, $search)
    {
        return $query->where(function($q) use ($search)
        {
            $q->whereHas('author', function($q) use ($search)
            {
                $q->where('name', 'LIKE', "%$search%");

            })->orWhere('title', 'LIKE', "%$search%");

            $q->orWhereHas('author', function($q) use ($search)
            {
                $q->where('nickname', 'LIKE', "%$search%");

            })->orWhere('title', 'LIKE', "%$search%");

        });
    }

    /**
     * Scopes the query to find objects where the title or author name matches
     * a search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthoredBy($query, $id)
    {
        return $query->where(function($q) use ($id)
        {
            $q->where('author_id', $id);
        });
    }

    /**
     * Scopes the query to find objects where the title name matches
     * a search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTitle($query, $search)
    {
        return $query->where(function($q) use ($search)
        {
            $q->where('title', 'LIKE', "%$search%");
        });
    }

    /**
     * Scopes the query to find objects where the author name matche a search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAuthor($query, $search)
    {
        return $query->where(function($q) use ($search)
        {
            $q->whereHas('author', function($q) use ($search)
            {
                $q->where('name', 'LIKE', "%$search%");

            });

            $q->orWhereHas('author', function($q) use ($search)
            {
                $q->where('nickname', 'LIKE', "%$search%");

            });

        });
    }
}
