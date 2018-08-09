<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getForgot()
    {
        return view('pages.forgot', [
            'page' => 'log-in'
        ]);
    }

    public function getReset($subdomain, $token = null)
    {
        return view('pages.reset', [
            'page' => 'log-in',
            'set' => 0,
            'token' => $token
        ]);
    }

    public function getSet($subdomain, $token = null)
    {
        $email = DB::select('select email from esi_password_resets where token LIKE  :token', ['token' => $token]);
        if(count($email)>0)
            return view('pages.reset', [
                'page' => 'log-in',
                'set' => 1,
                'email' => $email[0]->email,
                'token' => $token
            ]);
        return redirect()->route('forgot', [
            'subdomain' => $subdomain
        ]);
    }
}
