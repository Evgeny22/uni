<?php

namespace App\Http\Controllers\VideoCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\ExemplarRepository;
use App\Video;

class ExemplarsController extends Controller
{
    /**
     * Mark a video as exemplar with a reason
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        /*if ($auth->user()->cannot('mark', $video)) {
            return abort(400, 'You do not have permission to mark this video as exemplar');
        }*/

        $marked = with(new ExemplarRepository)->markAsExemplar($video, $request->get('reason'));

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This video post has successfully become a resource.');

        return $marked ? redirect()->back() : abort(400, 'There was a problem marking this video as an exemplar.');
    }

    /**
     * Accept the exemplar for a video
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if ($auth->user()->cannot('accept', $video)) {
            return abort(400, 'You do not have permission to accept this video as exemplar');
        }

        $accepted = with(new ExemplarRepository)->acceptAsExemplar($video);

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This post is now an exemplar.');

        return $accepted ? redirect()->back() : abort(400, 'There was a problem accepting this video as exemplar');
    }

    /**
     * Deny the exemplar for a video
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if ($auth->user()->cannot('accept', $video)) {
            return abort(400, 'You do not have permission to deny this video as exemplar');
        }

        $accepted = with(new ExemplarRepository)->denyAsExemplar($video,$request->get('reason'));

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This post is no longer an exemplar.');

        return $accepted ? redirect()->back() : abort(400, 'There was a problem denying this video as exemplar');
    }
}
