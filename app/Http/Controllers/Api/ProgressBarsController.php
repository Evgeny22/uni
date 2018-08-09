<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\VideoRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\ProgressBar;

class ProgressBarsController extends Controller
{
    public function searchTitle($subdomain, Guard $auth, Request $request)
    {
        $progressBars = ProgressBar::where('name', 'LIKE', '%'. $request->get('q') .'%')->get();

        return ['results' => $progressBars];
    }

    public function searchAuthor($subdomain, Guard $auth, Request $request)
    {
        $progressBarAuthors = ProgressBar::with('author')
            ->searchAuthor($request->get('q'))
            ->groupBy('author_id')
            ->get();

        return [
            'results' => $progressBarAuthors
        ];
    }
}
