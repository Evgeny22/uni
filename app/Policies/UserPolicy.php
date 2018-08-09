<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

/**
 * Handles permissions for handling actions on users
 *
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to view another user
     *
     * @param App\User $user
     * @param App\User $other
     * @return boolean
     */
    public function view(User $user, User $other)
    {
        // A user can view themselves
        if ($user->id == $other->id) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to update another user
     *
     * @param App\User $user
     * @param App\User $other
     * @return boolean
     */
    public function update(User $user, User $other)
    {
        // A user can update themselves
        if ($user->id == $other->id) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to delete another user
     *
     * @param App\User $user
     * @param App\User $other
     * @return boolean
     */
    public function delete(User $user, User $other)
    {
        return $user->is('super_admin');
    }
}
