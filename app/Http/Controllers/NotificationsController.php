<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\ActivityRepository;

use App\Http\Requests;

class NotificationsController extends Controller
{
    public function index($subdomain, Guard $auth, Request $request) {
        $notifications = with(new ActivityRepository)->getActivitiesForUserWhereAuthorIsNotUserWithRead(
            $auth->user()->id,
            10,
            $request->get('type'),
            $request->get('year'),
            $request->get('month'),
            $request->get('day')
        );

        //dump($notifications);
        
        return view('notifications.index', [
            'page' => 'notifications',
            'title' => 'Notifications',
            'notifications' => $notifications
        ]);
    }
}
