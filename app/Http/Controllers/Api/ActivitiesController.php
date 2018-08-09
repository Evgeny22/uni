<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LessonPlanRepository;
use App\Activity;
use App\Repositories\ActivityRepository;

class ActivitiesController extends Controller
{
    /**
     * Delete an annotation
     *
     * @param string $subdomain
     * @param int $userId
     * @return Illuminate\View\View;
     */
    public function markReadByUserId($subdomain, Guard $auth, Request $request, $userId)
    {
        $date = Carbon::now();

        $notificationIds = with(new ActivityRepository)->getActivitiesForUserWhereAuthorIsNotUserWithReadCollection(
            $auth->user()->id,
            999
        )->pluck('id');

        // Mark notifications as read
        $markAsRead = Activity::whereIn('id', $notificationIds)
            ->update([
                'read_at' => $date->toDateTimeString()
            ]);

        return response(200);
    }
}
