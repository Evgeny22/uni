<?php

namespace App\Http\Controllers\Api\Messages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Message;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Store a new comment for a message
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the message the user is commenting on
        $message = Message::findOrFail($id);

        // If the user doesn't have permission to comment on this message then
        // throw a 403 error
        if ($auth->user()->cannot('comment', $message)) {
            abort(403, 'You do not have permission to comment on this message');
        }

        $parentId = $request->get('parent_id');

        $saved = $message->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        return $saved ? response(['comment_id' => $saved->id], 200) : abort(400);
    }
}
