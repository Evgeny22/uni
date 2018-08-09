<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Video;
use App\User;
use App\Traits\IsShareable;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\VideoRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\UserShare;
use App\UserShareObject;
use App\UserSave;
use Illuminate\Support\Facades\DB;
use App\UserSaveObject;


/**
 * Handles permissions for performing updates on videos
 *
 */
class VideoPolicy
{
    use HandlesAuthorization;
    
    
    /**
     * Checks if the user has permission to view a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function view(User $user, Video $video)
    {

        $accessGranted = '0';
        $accessToVideo = DB::table('user_share_objects')
            ->leftJoin('user_shares', 'user_share_objects.user_share_id', '=', 'user_shares.id')
            ->where('object_id', $video->id)
            ->get();

        foreach ($accessToVideo as $accessToVideoUser) {
            if ($accessToVideoUser->recipient_id == $user->id) {
                $accessGranted = '1';
                break;
            }
        }

        if ( $user->isEither(['project_admin', 'super_admin']) || $video->isAuthoredBy($user) || $video->hasParticipant($user) || $video->isExemplar || $accessGranted == 1) {
            return true;
        } else {
            if($video->hidden)
            return false;
        }

//        if($video->hidden)
//            return false;
//
//        // Is the user the author
//        if ($video->isAuthoredBy($user)) {
//            return true;
//        }
//
//        // Is the user a participant of the videos
//        if ($video->hasParticipant($user)) {
//            return true;
//        }
//
//        // Is the video is exemplar
//        if($video->isExemplar){
//            return true;
//        }
//
//        // Has the video been shared to the user
//        if ($video->belongsTo($user)) {
//            return true;
//        }
//
//        // Is the user is either a project admin or a super admin
//        return $user->isEither(['project_admin', 'super_admin']);

    }

    /**
     * Checks if the user has permission to create a new video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function create(User $user, Video $video)
    {
        return $user->isEither(['teacher', 'master_teacher', 'coach', 'school_leader', 'project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to update a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function update(User $user, Video $video)
    {
        // Is the user the author
        if ($video->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to update a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function destroy(User $user, Video $video)
    {
        // Is the user the author
        if ($video->isAuthoredBy($user)) {
            return true;
        }

        return $user->is('super_admin');
    }

    /**
     * Checks if the user has permission to comment on a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function comment(User $user, Video $video)
    {
        // Is the user the author
        if ($video->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the videos
        if ($video->hasParticipant($user)) {
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to annotate a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function annotate(User $user, Video $video)
    {
        // Is the user the author
        if ($video->isAuthoredBy($user)) {
            return true;
        }

        // Is the user a participant of the videos
        if ($video->hasParticipant($user)) {
            return true;
        }

        // Has the video been shared to the user
        if ($video->belongsTo($user)) {
            return true;
        }

        // Is the user is either a project admin or a super admin
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to mark a video as exemplar
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function mark(User $user, Video $video)
    {
        return $user->isEither(['master_teacher', 'coach', 'super_admin']);
    }

    /**
     * Checks if the user has permission to accept a video as exemplar
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function accept(User $user, Video $video)
    {
        return $user->isEither(['project_admin', 'super_admin']);
    }
    /**
     * Checks if the user has permission to deny a video as exemplar
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function deny(User $user, Video $video)
    {
        return $user->isEither(['project_admin', 'super_admin']);
    }

    /**
     * Checks if the user has permission to attach a document to a video
     *
     * @param App\User $user
     * @param App\Video $video
     * @return boolean
     */
    public function document(User $user, Video $video)
    {
        if ($video->isAuthoredBy($user)) {
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
    public function exemplars(User $user, Video $video)
    {
        return $user->is('super_admin');
    }
}
