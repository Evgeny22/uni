<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\LessonPlan;
use App\User;

/**
 * Handles permissions for performing updates on lesson plans
 *
 */
class LessonPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user has permission to view a lesson plan
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function view(User $user, LessonPlan $lessonPlan)
    {
        // Is the user the author
        if ($lessonPlan->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the lesson plan
        if ($lessonPlan->hasParticipant($user)) {
            return true;
        }

        // Is the lesson Plan is exemplar
        if($lessonPlan->isExemplar){
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to update a lesson plan
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function update(User $user, LessonPlan $lessonPlan)
    {
        if ($lessonPlan->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to update a lesson plan
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function destroy(User $user, LessonPlan $lessonPlan)
    {
        if ($lessonPlan->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to comment on a lesson plan
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function comment(User $user, LessonPlan $lessonPlan)
    {
        // Is the user the author
        if ($lessonPlan->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the lesson plan
        if ($lessonPlan->hasParticipant($user)) {
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to mark a video as exemplar
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function mark(User $user, LessonPlan $lessonPlan)
    {
        return $user->isEither(['master_teacher', 'super_admin']);
    }

    /**
     * Checks if the user has permission to accept a video as exemplar
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function accept(User $user, LessonPlan $lessonPlan)
    {
        return $user->isEither(['project_admin', 'super_admin']);
    }
    /**
     * Checks if the user has permission to deny a video as exemplar
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function deny(User $user, LessonPlan $lessonPlan)
    {
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to attach a document to a lesson plan
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function document(User $user, LessonPlan $lessonPlan)
    {
        if ($lessonPlan->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }
    
    /**
     * Checks if the user has permission to see exemplar requests
     *
     * @param App\User $user
     * @param App\LessonPlan $lessonPlan
     * @return boolean
     */
    public function exemplars(User $user, LessonPlan $lessonPlan)
    {
        return $user->is('super_admin');
    }
}
