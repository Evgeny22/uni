<?php

namespace App\Http\Controllers\Api\InstructionalDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\LessonPlan;
use App\Comment;

class ParticipantsController extends Controller
{
    /**
     * List out the participants for the message
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function index($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        // If the user doesn't have permission to view this lesson plan than throw
        // an error
        if ($auth->user()->cannot('view', $lessonPlan)) {
            abort(403, 'You do not have permission to view this lesson plan');
        }

        return $lessonPlan->participants;
    }
}
