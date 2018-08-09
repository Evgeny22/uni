<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Message;
use App\User;

/**
 * Handles permissions for performing updates on messages
 *
 */
class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to view a message
     *
     * @param App\User $user
     * @param App\Message $message
     * @return boolean
     */
    public function view(User $user, Message $message)
    {
        // Is the user the author
        if ($message->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the message
        if ($message->hasParticipant($user)) {
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to update a message
     *
     * @param App\User $user
     * @param App\Message $message
     * @return boolean
     */
    public function update(User $user, Message $message)
    {
        // Is the user the author
        if ($message->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to update a message
     *
     * @param App\User $user
     * @param App\Message $message
     * @return boolean
     */
    public function destroy(User $user, Message $message)
    {
        // Is the user the author
        if ($message->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to comment on a message
     *
     * @param App\User $user
     * @param App\Message $message
     * @return boolean
     */
    public function comment(User $user, Message $message)
    {
        // Is the user the author
        if ($message->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the message
        if ($message->hasParticipant($user)) {
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }
}
