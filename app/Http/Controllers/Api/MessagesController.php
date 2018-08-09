<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    /**
     * Lists out messages and allows the user to search
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, Request $request)
    {
        $messages = with(new MessageRepository)->messagesForUser(
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );

        $messages->getCollection()->map(function($message)
        {
            $message->text = "\"{$message->title}\" by {$message->author->displayName}";
            $message->avatar = $message->author->avatar->url();
        });

        return ['results' => $messages->items()];
    }
}
