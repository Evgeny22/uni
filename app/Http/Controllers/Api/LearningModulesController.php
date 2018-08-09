<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\LearningModuleRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;

class LearningModulesController extends Controller
{
    /**
     * Lists out learning modules and allows the user to search
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, Request $request)
    {
        $learningModules = with(new LearningModuleRepository)->all(
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );
        $learningModules->getCollection()->map(function($learningModule)
        {
            $learningModule->hide_author = 1;
        });
        return ['results' => $learningModules->items()];
    }
}
