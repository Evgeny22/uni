<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Role;
use App\School;
use Mail;
use Uuid;

class PagesController extends Controller
{
    /**
     * Displays the FAQ page.
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function getFaq(Guard $auth)
    {

        return view('pages/faq', [
            'title' => 'FAQ',
            'page' => 'faq'
        ]);
    }

    /**
     * Displays the Help page.
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function getHelp(Guard $auth)
    {

        return view('pages/help', [
            'title' => 'Help',
            'page' => 'help'
        ]);
    }

    /**
     * Displays the Report an Issue page.
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function getReportIssue(Guard $auth)
    {

        return view('pages/report-issue', [
            'title' => 'Report an Issue',
            'page' => 'report-issue'
        ]);
    }
}
