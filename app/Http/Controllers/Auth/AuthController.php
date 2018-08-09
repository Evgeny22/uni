<?php

namespace App\Http\Controllers\Auth;

use App\School;
use App\User;
use App\Role;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $loginPath = '/login';
    private $redirectTo = '/progress-bars';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('pages/login', [
            'page' => 'log-in',
            'title' => 'Login'
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        // Get all schools and their classrooms
        $schools = School::with('classrooms')->get();
        
        return view('pages/signup', [
            'page' => 'signup',
            'schools' => $schools]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'name' => 'required|max:255',
            'classroom_id' => 'required',
            'school_id' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // If the user is registering then they must be a parent
        $role = Role::where('machine_name', 'parent')->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'classroom_id' => array_get($data, 'classroom_id'),
            'role_id' => $role->id
        ]);

        // Get the schools
        $schools = collect(array_get($data, 'school_id'))->toArray();

        // Assign any schools to the user
        $user->schools()->sync($schools);

        return $user;
    }
}
