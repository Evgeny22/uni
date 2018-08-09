<?php

namespace App\Http\Controllers\InstructionalDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\ExemplarRepository;
use App\LessonPlan;

class ExemplarsController extends Controller
{
    /**
     * Mark a Lesson Plan as exemplar with a reason
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        if ($auth->user()->cannot('mark', $lessonPlan)) {
            return abort(400, 'You do not have permission to mark this Lesson Plan as exemplar');
        }

        $marked = with(new ExemplarRepository)->markAsExemplar($lessonPlan, $request->get('reason'));

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'This Lesson Plan is now pending to be exemplar. An administrator will now review your request and respond appropriately.');

        return $marked ? redirect()->back() : abort(400, 'There was a problem marking this Lesson Plan as exemplar');
    }

    /**
     * Accept the exemplar for a Lesson Plan
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        if ($auth->user()->cannot('accept', $lessonPlan)) {
            return abort(400, 'You do not have permission to accept this Lesson Plan as exemplar');
        }

        $accepted = with(new ExemplarRepository)->acceptAsExemplar($lessonPlan);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'This Lesson Plan is now an exemplar.');

        return $accepted ? redirect()->back() : abort(400, 'There was a problem accepting this Lesson Plan as exemplar');
    }

    /**
     * Deny the exemplar for a Lesson Plan
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        if ($auth->user()->cannot('accept', $lessonPlan)) {
            return abort(400, 'You do not have permission to deny this Lesson Plan as exemplar');
        }

        $accepted = with(new ExemplarRepository)->denyAsExemplar($lessonPlan);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'This Lesson Plan is no longer an exemplar.');

        return $accepted ? redirect()->back() : abort(400, 'There was a problem denying this Lesson Plan as exemplar');
    }
}
