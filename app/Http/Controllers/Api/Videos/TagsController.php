<?php

namespace App\Http\Controllers\Api\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Video;
use App\Comment;

class TagsController extends Controller
{
    /**
     * List out the participants for the video
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function index($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        // If the user doesn't have permission to view this video than throw
        // an error
        if ($auth->user()->cannot('view', $video)) {
            abort(403, 'You do not have permission to view this video');
        }

        return $video->tags;
    }
}
