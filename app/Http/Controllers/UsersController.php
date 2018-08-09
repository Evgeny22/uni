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
use Illuminate\Auth\Passwords\TokenRepositoryInterface;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function index(Guard $auth)
    {
        // Get all users paginated by 20
        $users = with(new UserRepository)->all(99999);

	    // Hide all except teacher (2), coach (3) and project admin (5)
	    $roles = Role::all()->filter(function($role)
	    {
		    return in_array($role->id, array(2, 3, 5));
	    });

        // Get all schools and their classrooms
        $schools = School::with('classrooms')
            ->with(['users' => function ($query) {
            $query->where('role_id', 3)->distinct();

        }])->get();

        return view('users.index', [
            'page' => 'users',
            'title' => 'Users',
            'users' => $users,
            'roles' => $roles,
            'schools' => $schools
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If the user is registering then they must be a parent
        $role = Role::findOrFail($request->input('user_role'));

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            //'masterteacher' => $request->input('masterteacher'),
            'password' => bcrypt(str_random(12)),
            'role_id' => $role->id
        ];

        if ($request->has('masterteacher')) {
            $data['masterteacher'] = $request->input('masterteacher');
        }

        // If the user isn't a project admin then they must have a classroom selected
        if ($role->machine_name !== 'project_admin') {
            $data['classroom_id'] = $request->input('classroom_id');
        }

        $exists = User::where('email',$request->input('email'))->count()>0;

        if ($exists) {
            // Show a success message
            $request->session()->flash('flash.title', 'Error');
            $request->session()->flash('flash.component', 'primary');
            $request->session()->flash('flash.message', 'This user can\'t be create. There is an user in the system with the same email.');

            return redirect()->back();
        }

        // Create the user
        $user = User::create($data);

        // If the user isn't a project admin then they must have a school attached
        if ($role->machine_name !== 'project_admin') {

            // Get the schools
            $schools = collect($request->input('school_id'))->toArray();

            // Assign any schools to the user
            $user->schools()->sync($schools);
        }

        // Create a password reset token for the user
        $token = app('auth.password.broker')->createToken($user);

        // Send the user an email
        Mail::send('emails.user.created', compact('user', 'token'), function ($m) use ($user) {
            $m->from('support@earlyscienceinitiative.org', 'Early Science Initiative');
            $m->to($user->email, $user->name)->subject("You've been invited to join the Early Science Initiative");
        });

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'primary');
        $request->session()->flash('flash.message', 'This user has now been created. A password creation email has been sent to them as well.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($auth->user()->cannot('delete', $user)) {
            return abort(400, 'You do not have permission to delete this user');
        }
        $user->email_deleted = $user->email;
        $user->email = (string)Uuid::generate(4);
        $user->save();

        $user->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'primary');
        $request->session()->flash('flash.message', 'This user has now been removed!');

        return redirect()->route('users', [
            'subdomain' => $subdomain
        ]);
    }
}
