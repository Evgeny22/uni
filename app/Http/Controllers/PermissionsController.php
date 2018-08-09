<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;

use App\Role;

class PermissionsController extends Controller
{
    /**
     * Display a list of all roles
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function index(Guard $auth) {
        // Get all roles
        $roles = Role::all();

        // @TODO: Implement permissions for this page
        //$user->is('super_admin') or $user->is('mod')
        /*$user = User::findOrFail($id);

        if ($auth->user()->cannot('delete', $user)) {
            return abort(400, 'You do not have permission to delete this user');
        }*/

        if (!$auth->user()->is('super_admin')) {
            return abort(400, 'You do not have permission to access the feature of the website.');
        }

        return view('permissions.index', [
            'page' => 'permissions',
            'title' => 'Permissions',
            'roles' => $roles
        ]);
    }

    public function update($subdomain, Guard $auth, Request $request, $id) {
        // Get role
        $role = Role::findOrFail($id);

        //dd($role);

        if (!$auth->user()->is('super_admin')) {
            return abort(400, 'You do not have permission to access the feature of the website.');
        }

        return view('permissions.update', [
            'page' => 'permissions',
            'title' => 'Editing Permissions',
            'role' => $role
        ]);
    }
}
