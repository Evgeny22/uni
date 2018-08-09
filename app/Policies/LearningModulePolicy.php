<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\LearningModule;
use App\User;

/**
 * Handles permissions for performing updates on learning modules
 *
 */
class LearningModulePolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to create a new video
     *
     * @param App\User $user
     * @param App\LearningModule $learningModule
     * @return boolean
     */
    public function create(User $user, LearningModule $learningModule)
    {
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to update a learning module
     *
     * @param App\User $user
     * @param App\LearningModule $learningModule
     * @return boolean
     */
    public function update(User $user, LearningModule $learningModule)
    {
        // Is the user the author
        if ($learningModule->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to update a learning module
     *
     * @param App\User $user
     * @param App\LearningModule $learningModule
     * @return boolean
     */
    public function destroy(User $user, LearningModule $learningModule)
    {
        // Is the user the author
        if ($learningModule->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to attach a document to a learning module
     *
     * @param App\User $user
     * @param App\LearningModule $learningModule
     * @return boolean
     */
    public function document(User $user, LearningModule $learningModule)
    {
        if ($learningModule->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }
}
