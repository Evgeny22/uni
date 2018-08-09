<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Resource;
use App\User;

/**
 * Handles permissions for performing updates on resources
 *
 */
class ResourcePolicy
{
    use HandlesAuthorization;
    

    /**
     * Checks if the user has permission to update a resource
     *
     * @param App\User $user
     * @param App\Resource $resource
     * @return boolean
     */
    public function update(User $user, Resource $resource)
    {
        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to delete a resource
     *
     * @param App\User $user
     * @param App\Resource $resource
     * @return boolean
     */
    public function destroy(User $user, Resource $resource)
    {
        return $user->is('super_admin');
    }    
}
