<?php

namespace App\Http\Controllers\InstructionalDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentStoreRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LessonPlanRepository;
use App\LessonPlan;

class DocumentsController extends Controller
{
    /**
     * Stores a document to a lesson plan
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\RedirectResponse;
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        if ($auth->user()->cannot('document', $lessonPlan)) {
            return abort(400, 'You do not have permission to attach a document to this lesson plan');
        }

        // Store a new document for this lesson plan
        with(new LessonPlanRepository)->document(
            $lessonPlan,
            $request->file('document'),
            $request->only('title', 'description', 'type')
        );

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'The document has been added to this Lesson Plan.');

        return redirect()->back();
    }

    public function storeLessonPlan($subdomain, Guard $auth, Request $request, $id) {
        $lessonPlan = LessonPlan::findOrFail($id);

        /*if ($auth->user()->cannot('document', $lessonPlan)) {
            return abort(400, 'You do not have permission to attach a document to this lesson plan');
        }*/
        
        // Store a new document for this lesson plan
        with(new LessonPlanRepository)->document(
            $lessonPlan,
            $request->file('lesson_plan'),
            $request->only('title', 'description', 'type')
        );

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'The document has been added to this Lesson Plan.');

        return redirect()->back();
    }
}
