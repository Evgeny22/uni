<?php

namespace App\Http\Controllers;

use App\Activity;
use Validator;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherSelectController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showAllSelected()
    {
        $user = Auth::user();

        $activities = Activity::getActivitiesByUser($user['id']);

        $teacher_list = [

            [
                'id' => 4,
                'name' => 'Chelsea Dawson',
                'email' => 'chelsea@uic.edu',
                'avatar' => 'chelsea_dawson',
            ],
            [
                'id' => 5,
                'name' => 'Carlos Gutierrez',
                'email' => 'cgutierrez@gmail.com',
                'avatar' => 'carlos_gutierrez',
            ],
            [
                'id' => 12,
                'name' => 'Raymond Felix',
                'email' => 'raymond@artisanmedia.com',
                'avatar' => 'ray_felix',
            ],

        ];

        return view('pages/teacher_select', [
            'page' => 'teacher-select',
            'title' => 'Teachers Selected',
            'user' => $user,
            'alert_count' => count($activities),
            'teacher_list' => $teacher_list,
        ]);

    }
}
