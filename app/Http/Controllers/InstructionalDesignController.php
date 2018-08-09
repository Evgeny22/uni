<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LessonPlanRepository;
use App\Repositories\GroupRepository;
use App\LessonPlan;
use App\Answer;
use PDF;

class InstructionalDesignController extends Controller
{
    /**
     * Shows a list of instructional designs for the user
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request)
    {
        $textInfo = "";
        
        if($request->has('search') && $request->get('search')=='true')
        {
            $lessonPlans = with(new LessonPlanRepository)->lessonPlansForUserByTag(
                $auth->id(),
                $request->get('take', 10),
                $request->get('sort'),
                urldecode($request->get('tags'))
            );

            $textInfo = "Results For: ".str_replace(",",", ",urldecode($request->get('tags'))).".";
            
        }
        else
            $lessonPlans = with(new LessonPlanRepository)->lessonPlansForUser(
                $auth->id(),
                $request->get('take', 10),
                $request->get('sort')
            );

        return view('instructional-design.index', [
            'page' => 'instructional-design',
            'title' => 'Instructional Design',
            'lessonPlans' => $lessonPlans,
            'resultFor' => $textInfo
        ]);
    }

    /**
     * Shows a single instructional design
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, $id)
    {
        $lessonPlan = LessonPlan::find($id);

        // If the user does not have permission to view the lesson plan then return a 404 error
        if ($auth->user()->cannot('view', $lessonPlan)) {
            return abort(404, 'This lesson plan either does not exist or you do not have permission to view it.');
        }

        $documents = $lessonPlan->documents()->where('type', '<>', 'lesson_plan')->get();
        
        $comments = $lessonPlan->comments()
            ->where('type', '<>', 'admin')
            ->whereNotNull('comment_date')
            ->get();
        $adminComments = $lessonPlan->comments()->where('type', '=', 'admin')->get();

        // Check if this lesson plan has a "lesson_plan" document
        $lessonPlanDocument = $lessonPlan->documents()->where('type', '=', 'lesson_plan')->first();

        // Get the answers that a user has created for this lesson plan
        //$answers = with(new LessonPlanRepository)->latestAnswers($lessonPlan);
        $answers = Answer::where('lesson_plan_id', '=', $lessonPlan->id)->get();

        $crosscuttingConcepts = Tag::where('type','Crosscutting Concepts')->get();
        $crosscuttingConcepts->map(function($crosscuttingConcept)
        {
            $crosscuttingConcept->name_checkbox = "crosscutting-concepts_".strtolower(str_replace(" ","-",$crosscuttingConcept->tag));

        });

        $practices = Tag::where('type','Practices')->get();
        $practices->map(function($practice)
        {
            $practice->name_checkbox = "practices_".strtolower(str_replace(" ","-",$practice->tag));

        });

        $coreIdeas = Tag::where('type','Core Ideas')->get();
        $coreIdeas->map(function($coreIdea)
        {
            $coreIdea->name_checkbox = "core-ideas_".strtolower(str_replace(" ","-",$coreIdea->tag));

        });

        return view('instructional-design.show', [
            'page' => 'instructional-design-show',
            'title' => 'Instructional Design',
            'lessonPlan' => $lessonPlan,
            'documents' => $documents,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            'answers' => $answers,
            'comments' => $comments,
            'adminComments' => $adminComments,
            'lessonPlanDocument' => $lessonPlanDocument
        ]);
    }

    /**
     * Download a lesson plan as PDF
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param int $id
     * @return Illuminate\View\View
     */
    public function download($subdomain, Guard $auth, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        $data = with(new LessonPlanRepository)->generatePdfData($lessonPlan);

        //return view('instructional-design.pdf', $data);

        $pdf = PDF::loadView('instructional-design.pdf', $data);

        return $pdf->download("lesson-plan-{$lessonPlan->id}.pdf");
    }

    /**
     * Updates an instructional design
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        if ($auth->user()->cannot('update', $lessonPlan)) {
            return abort(400, 'You do not have permission to edit this lesson plan');
        }

        $lessonPlan->fill(array_filter($request->only('title', 'description')));

        // If participants were selected for this lesson plan then add them here
        $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($request->input('participants')));

        // Attach the user participants to the lesson plan
        $lessonPlan->participants()->sync($participantIds);
        
        $lessonPlan->save();

        // Store answers to the questions if its coming from the show view
        if($request->has('hasAnswers'))
            with(new LessonPlanRepository)->storeAnswers($lessonPlan, array_filter($request->except([
                'title',
                'description',
                '_token',
                '_method'
            ])));

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'Your Lesson Plan has been successfully updated!');

        // Send the user back to the page they were on
        return redirect()->route('instructional-design.show', [
            'subdomain' => $subdomain,
            'id' => $lessonPlan->id
        ]);

    }

    /**
     * Create a new lesson plan
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain,Guard $auth, Request $request)
    {
        // Create a new lesson plan
        $lessonPlan = LessonPlan::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'author_id' => $auth->id()
        ]);

        // If participants were selected for this lesson plan then add them here
        if ($participants = $request->input('participants')) {

            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));

            // Attach the user participants to the lesson plan
            $lessonPlan->participants()->sync($participantIds);
        }

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'Your lesson plan has been successfully posted below! Tagged participants will be notified when they log in.');

        // Redirect the user to the lesson plan show page
        return redirect()->route('instructional-design.show', [
            'subdomain' => $subdomain,
            'id' => $lessonPlan->id
        ]);
    }

    /**
     * Destroys a lesson plan
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {

        $lessonPlan = LessonPlan::findOrFail($id);

        if ($auth->user()->cannot('destroy', $lessonPlan)) {
            return abort(400, 'You do not have permission to delete this lesson plan');
        }

        $lessonPlan->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'The Lesson Plan has been successfully deleted!');

        return redirect()->route('instructional-design.index', [
            'subdomain' => $subdomain,
        ]);
    }

    /**
     * SHows a list of lessonsPlans waiting for be exemplar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function exemplars($subdomain, Guard $auth, Request $request)
    {
        $exemplars = with(new LessonPlanRepository())->lessonPlansWaitingForApprove(
            $auth->id(),20);

        $lessonPlan = LessonPlan::first();

        if ($auth->user()->cannot('exemplars', $lessonPlan)) {
            return abort(404, 'This page does not exist or you do not have permission to view it.');
        }

        return view('instructional-design.exemplars', [
            'page' => 'instructional-design',
            'title' => 'Instructional Design',
            'exemplars' => $exemplars
        ]);
    }
}
