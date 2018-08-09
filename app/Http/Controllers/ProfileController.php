<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Message;
use App\Activity;
use App\Repositories\ActivityRepository;
use App\User;
use App\Role;
use App\School;

class ProfileController extends Controller
{
    /**
     * Show the user's profile page
     *
     * @param string $subdomain
     * @param int $id
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        /*if ($auth->user()->cannot('view', $user)) {
            return abort(400, 'You do not have permission to view this user');
        }*/

        return view('profile.index', [
            'page' => 'profile',
            'title' => 'Profile',
            'profile' => $user
        ]);
    }

    /**
     * Show the user's activity page
     *
     * @param string $subdomain
     * @param int $id
     * @return Illuminate\View\View
     */
    public function activity($subdomain, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('view', $user)) {
            return abort(400, 'You do not have permission to view this user');
        }

        $activities = with(new ActivityRepository)->getActivitiesForUser(Auth::id(), 20);

        return view('profile.activity', [
            'page' => 'activity',
            'title' => 'Activity',
            'profileActivities' => $activities
        ]);
    }

    /**
     * Show the user's activity page
     *
     * @param string $subdomain
     * @param int $id
     * @return Illuminate\View\View
     */
    public function authoredActivity($subdomain, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('view', $user)) {
            return abort(400, 'You do not have permission to view this user');
        }

        $activities = with(new ActivityRepository)->getProfileActivity($id);

        return view('profile.authoredActivity', [
            'page' => 'activity',
            'title' => 'Authored Activity',
            'authoredActivities' => $activities
        ]);
    }

    /**
     * Show the form for editing a user's profile
     *
     * @param string $subdomain
     * @param int $id
     * @return Illuminate\View\View
     */
    public function edit($subdomain, Request $request, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('update', $user)) {
            return abort(400, 'You do not have permission to update this user');
        }

        // Get all but the super admin role
        $roles = Role::all()->reject(function($role)
        {
            return $role->machine_name == 'super_admin';
        });

        // Get all schools and their classrooms
        $schools = School::with('classrooms')
            ->with(['users' => function ($query) {
                $query->where('role_id', 3)->distinct();

            }])->get();

        return view('profile.edit', [
            'page' => 'profile',
            'title' => 'Profile',
            'subdomain' => $subdomain,
            'profile' => $user,
            'roles' => $roles,
            'schools' => $schools
        ]);
    }

    public function updateProfile($subdomain, Request $request, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('update', $user)) {
            return abort(400, 'You do not have permission to update this user');
        }

        if ( 'cancel' == $request->input('action') ) {
            return redirect()->route('profile');
        }

        $user->update($request->all());

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'primary');
        $request->session()->flash('flash.message', 'Your profile has been successfully updated!');

        return redirect()->route('profile.edit', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);

    }

    public function updateAvatar($subdomain, Request $request, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('update', $user)) {
            return abort(400, 'You do not have permission to update this user');
        }

        //$user->avatar = $request->file('avatar');
        //$user->save();

        $path = $request->file('avatar');
        //dd($path);

        $user->avatar = $path;
        $user->save();

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'primary');
        $request->session()->flash('flash.message', 'Your Avatar has been successfully updated!');

        return redirect()->route('profile.edit', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function updatePassword($subdomain, Request $request, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('update', $user)) {
            return abort(400, 'You do not have permission to update this user');
        }

        if ($request->input('password') == $request->input('password2')) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
        }

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'primary');
        $request->session()->flash('flash.message', 'Your password has been successfully updated!');

        return redirect()->route('profile.edit', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function showAuthoredActivity($subdomain, Guard $auth, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('view', $user)) {
            return abort(400, 'You do not have permission to view this user');
        }

        $authoredActivities = Activity::getActivitiesByUser($user['id']);
        $activities = Activity::getParticipatingActivitiesForUser($user['id']);

        return view('pages/authored-activity')
            ->with(['page' => 'authored-activity',
                'title' => 'Profile',
                'alert_count' => count($activities),
                'user' => $user,
                'activities' => $authoredActivities
            ])
        ;
    }
}
