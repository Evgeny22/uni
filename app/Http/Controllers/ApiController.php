<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ApiController extends Controller
{
    public function listTeachers(Request $request)
    {
        $user = Auth::user();

        return [
            'results' => User::fetchParticipantsList($user, [
                'search' => $request->input('q'),
                'url_prefix' => $request->root()
            ]),
        ];
    }

    public function get()
    {
        return [];
    }
}
