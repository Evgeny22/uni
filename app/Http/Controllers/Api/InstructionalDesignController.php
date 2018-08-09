<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\LessonPlanRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;

class InstructionalDesignController extends Controller
{
    /**
     * Lists out lesson plans and allows the user to search
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, Request $request)
    {
        $lessonPlans = with(new LessonPlanRepository)->lessonPlansForUser(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );

        $lessonPlans->getCollection()->map(function($lessonPlan)
        {
            $lessonPlan->avatar = $lessonPlan->author->avatar->url();
        });

        return ['results' => $lessonPlans->items()];
    }
}
