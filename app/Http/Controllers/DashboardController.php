<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProgressBar;

class DashboardController extends Controller
{
    /**
     * Main dashboard page
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View;
     */
    public function index(Request $request)
    {
        // Fetch progress bars
        $progressBars = ProgressBar::all();

        // Fetch progress bars with templates
        $progressBarTemplates = ProgressBar::where('is_template', '1')->get();

        return view('pages/dashboard', [
            'page' => 'dashboard',
            'title' => 'Home',
            'progressBars' => $progressBars,
            'progressBarTemplates' => $progressBarTemplates
        ]);
    }

    public function keepAlive(Request $request) {
        // Get tokens from session and the request
        $sessionToken = $request->session()->token();
        $token        = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        // Validate them
        return response()->json(hash_equals((string) $sessionToken, (string) $token));
    }
}
