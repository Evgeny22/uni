<?php

namespace App\Http\Controllers\Api\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Video;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Store a new comment for a video
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the video the user is commenting on
        $video = Video::findOrFail($id);

        // If the user doesn't have permission to comment on this video then
        // throw a 403 error
        if ($auth->user()->cannot('comment', $video)) {
            abort(403, 'You do not have permission to comment on this video');
        }

        $parentId = $request->get('parent_id');

        $saved = $video->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        return $saved ? response(['comment_id' => $saved->id], 200) : abort(400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        /*if ($auth->user()->cannot('delete', $comment)) {
            return abort(400, 'You do not have permission to delete this comment');
        }*/

        return $comment->delete() ? response(null, 200) : abort(400);
    }
}
