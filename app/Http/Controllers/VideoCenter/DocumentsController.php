<?php

namespace App\Http\Controllers\VideoCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentStoreRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\VideoRepository;
use App\Video;

class DocumentsController extends Controller
{
    /**
     * Destroys a document that's attached to a video
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\RedirectResponse;
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if ($auth->user()->cannot('document', $video)) {
            return abort(400, 'You do not have permission to attach a document to this video');
        }

        // Store a new document for this video
        with(new VideoRepository)->document(
            $video,
            $request->file('document'),
            $request->only('title', 'description')
        );

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your supporting document has been successfully uploaded to this video post.');

        return redirect()->back();
    }

}
