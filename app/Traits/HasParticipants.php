<?php

namespace App\Traits;

use App\User;

trait HasParticipants
{
    /**
     * An object can have many user participants
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function participants()
    {
        return $this->morphToMany(User::class, 'userable');
    }

    /**
     * Checks if this object has the user as a participant
     *
     * @param App\User $user
     * @return bool
     */
    public function hasParticipant(User $user)
    {
        return $this->participants
            ->where('id', $user->id)
            ->count() > 0;
    }

    /**
     * Scopes the query to return only objects that the user is either participating in
     * or has authored
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthoredOrParticipating($query, $id)
    {
        return $query->where(function($q) use ($id)
        {
            $q->whereHas('participants', function($q) use ($id) {
                $q->where('user_id', $id);
            })->orWhere('author_id', $id);
        });
    }

    /**
     * Scopes the query to return only objects that the user is participating in
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipating($query, $id)
    {
        return $query->whereHas('participants', function ($q) use ($id) {
            $q->where('user_id', $id);
        });
    }

    public function scopeIsParticipant($query, $id) {
        return $query->whereHas('steps', function ($q) use ($id) {
            $q->where('participant_id', $id);
        });
    }

    public function scopeIsAParticipant($query, $id) {
        return $query->whereHas('participants', function ($q) use ($id) {
            $q->where('user_id', $id);
        });
    }

    /**
     * Scopes the query to return only objects that the user is either participating in
     * or has authored
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthoredOrParticipatingExemplar($query, $id)
    {
        return $query->where(function($q) use ($id)
        {
            $q->whereHas('participants', function($q) use ($id) {
                $q->where('user_id', $id);
            })->orWhere('author_id', $id)
            ->orWhereHas('exemplars',function($q) {
                $q->where('approved',1);
            });
        });
    }
}
