<?php

namespace App\Http\Controllers\Api\Messages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Message;
use App\Comment;

class ParticipantsController extends Controller
{
    /**
     * List out the participants for the message
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function index($subdomain, Guard $auth, Request $request, $id)
    {
        $message = Message::findOrFail($id);

        // If the user doesn't have permission to view this message than throw
        // an error
        if ($auth->user()->cannot('view', $message)) {
            abort(403, 'You do not have permission to view this message');
        }

        return $message->participants;
    }
}
