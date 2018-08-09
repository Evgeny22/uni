<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use App\UserShare;
use App\UserShareObject;
use App\Traits\HasParticipants;

class UserSharesController extends Controller
{
    /**
     * Create a new shared object
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

        $participants = $request->get('participants');

        foreach ($participants as $participant) {
            // Create the new UserShare object
            $userShare = UserShare::create(['author_id' => $auth->user()->id, 'recipient_id' => $participant]);

            // Create the UserShareObject object
            $userShareObject = UserShareObject::create([
                'user_share_id' => $userShare->id,
                'object_id' => $request->get('object_id'),
                'object_type' => $request->get('object_type')
            ]);

            $userShare->participants()->attach($participant);
            $userShare->record();
        }

        switch ($request->get('object_type')) {
            case 'App\Video':
            case 'App\VideoColumn':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your video has been successfully shared!');

                // Redirect the user to the video show page
                return redirect()->route('video-center.show', [
                    'subdomain' => $subdomain,
                    'id' => $request->get('object_id')
                ]);
            break;

            case 'App\ProgressBar':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your progress bar has been successfully shared!');

                // Redirect the user to the video show page
                return redirect()->route('progress-bars.show', [
                    'subdomain' => $subdomain,
                    'id' => $request->get('object_id')
                ]);
            break;

            case 'App\Resource':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your Resource has been successfully shared!');

                // Redirect the user to the video show page
                return redirect()->route('resources.show', [
                    'subdomain' => $subdomain,
                    'id' => $request->get('object_id')
                ]);
                break;
        }

        return response(null, 200);
    }

    public function destroy($subdomain, Guard $auth, Request $request)
    {
        $saved = UserShare::where('id', $request->get('share_id'))
                ->first();

        $saved->delete();

        $savedObject = UserShareObject::where('user_share_id', $request->get('share_id'))
                        ->first();

        $savedObject->delete();

        switch ($request->get('object_type')) {
            case 'App\Video':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'Your video has been successfully unshared!');
                break;
        }

        return response(null, 200);
    }
}
