<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Annotation;
use App\User;

/**
 * Handles permissions for performing updates on messages
 *
 */
class AnnotationPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to destroy an annotation
     *
     * @param App\User $user
     * @param App\Annotation $annotation
     * @return boolean
     */
    public function destroy(User $user, Annotation $annotation)
    {
        // Is the user is the author of the annotation
        if ($annotation->isAuthoredBy($user)) {
            return true;
        }

        // Or is a super admin
        return $user->is('super_admin');
    }
}
