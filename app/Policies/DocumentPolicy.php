<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Document;
use App\User;

/**
 * Handles permissions for performing updates on messages
 *
 */
class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to destroy a document
     *
     * @param App\User $user
     * @param App\Document $document
     * @return boolean
     */
    public function destroy(User $user, Document $document)
    {
        // Is the user is the author of the document
        if ($document->isAuthoredBy($user)) {
            return true;
        }

        // Or is a super admin
        return $user->is('super_admin');
    }
}
