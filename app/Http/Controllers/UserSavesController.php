<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use App\UserSave;
use App\UserSaveObject;

class UserSavesController extends Controller
{
    /**
     * Create a new saved object
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video
        /*if ($auth->user()->cannot('create', new Video)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create the new UserShare object
        $userSave = UserSave::create([
            'author_id' => $auth->user()->id
        ]);

        // Create the UserShareObject object ;)
        $userSaveObject = UserSaveObject::create([
            'user_save_id' => $userSave->id,
            'object_id' => $request->get('object_id'),
            'object_type' => $request->get('object_type')
        ]);

        switch ($request->get('object_type')) {
            case 'App\Video':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your video has been successfully bookmarked!');
                break;

            case 'App\Message':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your message has been successfully bookmarked!');

                break;

            case 'App\Resource':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your Resource has been successfully bookmarked!');

                break;
        }

        return response(null, 200);
    }

    public function destroy($subdomain, Guard $auth, Request $request)
    {
//        $saved = UserSave::where('id', $request->get('save_id'))
//            ->where('object_id', $request->get('object_id'))
//            ->whereHas('userSave', function($q) use ($auth) {
//                $q->where('author_id', $auth->user()->id);
//            })->first();
//
//        $saved->delete();

        $saved = UserSave::where('id', $request->get('save_id'))
            ->first();

        $saved->delete();

        $savedObject = UserSaveObject::where('user_save_id', $request->get('save_id'))
            ->first();

        $savedObject->delete();

        switch ($request->get('object_type')) {
            case 'App\Video':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your video has been successfully unbookmarked!');
                break;

            case 'App\Message':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your message has been successfully unbookmarked!');

                break;

            case 'App\Resource':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your Resource has been successfully unbookmarked!');

                break;
        }

        return response(null, 200);
    }
}
