<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;

use App\RecoverRequest;

class RecoverRequestsController extends Controller
{
    public function store($subdomain, Guard $auth, Request $request) {
        $deleteRequest = RecoverRequest::create([
            'author_id' => $auth->user()->id,
            'object_id' => $request->get('object_id'),
            'object_type' => str_replace(' ', '', $request->get('object_type'))
        ]);

        switch ($request->get('object_type')) {
            case 'App\Video':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'You have requested for this video to be recovered.');
                break;

            case 'App\Message':
                // Generate a message for the user
                $request->session()->flash('flash.title', 'Success!');
                $request->session()->flash('flash.component', 'vc');
                $request->session()->flash('flash.message', 'You have requested for this message to be recovered.');

                return redirect()->route('messages.show', [
                    'subdomain' => $subdomain,
                    'id' => $request->get('object_id')
                ]);

                break;
        }

        return response(null, 200);
    }

    public function approve($subdomain, Guard $auth, Request $request, $id) {
        $recoverRequest = RecoverRequest::where('id', $id);

        $recoverRequest->update(['approved' => '1', 'recoverer_id' => $auth->user()->id]);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This has been approved to be recovered.');

        return redirect()->back();
    }

    public function deny($subdomain, Guard $auth, Request $request, $id) {
        $recoverRequest = RecoverRequest::where('id', $id);

        $recoverRequest->update(['approved' => '0', 'recoverer_id' => $auth->user()->id]);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This recover request has been denied.');

        return redirect()->back();
    }
}
