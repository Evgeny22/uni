<?php

namespace App\Repositories;

use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Activity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Support\Facades\DB;

use App\Video;
use App\LessonPlan;
use App\Message;

use Illuminate\Auth;

class ActivityRepository
{
    /**
     * Gets all activities that a user either authored or is participating in
     *
     * @param int $id
     * @param int $limit
     * @return Illuminate\Support\Collection;
     */
    public function getActivitiesForUser($id, $limit = 5)
    {
        $activities = Activity::leftJoin('userables', function($join) {
            $join->on('userables.userable_id', '=', 'activities.activitied_id')
                ->on('userables.userable_type', '=', 'activities.activitied_type');
        })->where('userables.user_id', '<>', $id)
        ->where('activities.author_id', $id)
        ->orderBy('activities.created_at', 'desc')->groupBy('activities.id');

        return $activities->paginate($limit);
    }

    /**
     * Gets all notifications (activities where the author IS NOT the user `$id`)
     *
     * @param int $id
     * @param int $limit
     * @return Illuminate\Support\Collection;
     */
    public function getActivitiesForUserWhereAuthorIsNotUser($id, $limit = 5) {
        $activities = Activity::with(['author', 'activitied'])
            ->leftJoin('userables', function ($join) {
                $join->on('userables.userable_id', '=', 'activities.activitied_id')
                    ->on('userables.userable_type', '=', 'activities.activitied_type');
            })->where('userables.user_id', '=', $id)// <-- VOODOO MAGIC
            ->where('activities.author_id', '<>', $id)
            //->whereNull('read_at')
            ->orderBy('activities.created_at', 'desc')
            ->groupBy('activities.id');

        return $activities->paginate($limit);
    }

    /**
     * Gets all notifications (activities where the author IS NOT the user `$id`)
     *
     * @param int $id
     * @param int $limit
     * @return Illuminate\Support\Collection;
     */
    public function getActivitiesForUserWhereAuthorIsNotUserWithRead($id, $limit = 5, $filterType = '', $filterYear = '', $filterMonth = '', $filterDay = '') {
        $activities = Activity::leftJoin('userables', function ($join) {
                $join->on('userables.userable_id', '=', 'activities.activitied_id')
                    ->on('userables.userable_type', '=', 'activities.activitied_type');
            })->where('userables.user_id', '=', $id)// <-- VOODOO MAGIC
            ->where('activities.author_id', '<>', $id)
            //->whereNull('read_at')
            ->orderBy('activities.created_at', 'desc')
            ->groupBy('activities.id');

        if (!empty($filterType)) {
            switch ($filterType) {
                case 'video-center':
                    $activities->where('activities.activitied_type', '=', Video::class);
                break;

                case 'message-board':
                    $activities->where('activities.activitied_type', '=', Message::class);
                break;

                case 'lesson-plans':
                    $activities->where('activities.activitied_type', '=', LessonPlan::class);
                break;
            }
        }

        if ($filterYear) {
            $activities->where(DB::raw('YEAR(created_at)'), '=', $filterYear);
        }

        if ($filterMonth) {
            $activities->where(DB::raw('MONTH(created_at)'), '=', $filterMonth);
        }

        if ($filterDay) {
            $activities->where(DB::raw('DAY(created_at)'), '=', $filterDay);
        }

        return $activities->paginate($limit);
    }

    /**
     * Gets all notifications (activities where the author IS NOT the user `$id`) and returns a collection
     *
     * @param int $id
     * @param int $limit
     * @return Illuminate\Support\Collection;
     */
    public function getActivitiesForUserWhereAuthorIsNotUserWithReadCollection($id) {
        $activities = Activity::leftJoin('userables', function ($join) {
            $join->on('userables.userable_id', '=', 'activities.activitied_id')
                ->on('userables.userable_type', '=', 'activities.activitied_type');
        })->where('userables.user_id', '=', $id)// <-- VOODOO MAGIC
        ->where('activities.author_id', '<>', $id)
            //->whereNull('read_at')
            ->orderBy('activities.created_at', 'desc')
            ->groupBy('activities.id');

        if (!empty($filterType)) {
            switch ($filterType) {
                case 'video-center':
                    $activities->where('activities.activitied_type', '=', Video::class);
                break;

                case 'message-board':
                    $activities->where('activities.activitied_type', '=', Message::class);
                break;

                case 'lesson-plans':
                    $activities->where('activities.activitied_type', '=', LessonPlan::class);
                break;
            }
        }

        return $activities->get();
    }

    /**
     * Gets all unread notifications (activities where the author IS NOT the user `$id`)  and returns a collection
     *
     * @param int $id
     * @param int $limit
     * @return Illuminate\Support\Collection;
     */
    public function getActivitiesForUserWhereAuthorIsNotUserOnlyUnreadCollection($id) {
        $activities = Activity::leftJoin('userables', function ($join) {
            $join->on('userables.userable_id', '=', 'activities.activitied_id')
                ->on('userables.userable_type', '=', 'activities.activitied_type');
        })->where('userables.user_id', '=', $id)// <-- VOODOO MAGIC
        ->where('activities.author_id', '<>', $id)
            ->whereNull('read_at')
            ->limit(10)
            ->orderBy('activities.created_at', 'desc')
            ->groupBy('activities.id');

        return $activities->get();
    }

    /**
     * Gets all activities that a user has authored
     *
     * @param int $id
     * @return Illuminate\Support\Collection
     */
    public function getProfileActivity($id)
    {
        return User::find($id)->authoredActivities()
            ->orderBy('activities.created_at', 'desc')
            ->get();
    }
}
