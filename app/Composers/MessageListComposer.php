<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Contracts\Auth\Guard;

class MessageListComposer
{
    /**
     * The message repository implementation.
     *
     * @var MessageRepository
     */
    protected $messages;

    /**
     * Create a new message list composer.
     *
     * @return void
     */
    public function __construct(Guard $auth, Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;
        $this->messages = new MessageRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get the first or last 10 messages for a user
        $messages = $this->messages->messagesForUser(
            10,
            $this->request->get('sort', 'desc'),
            $this->request->get('message')
        );

        $view->with('messages', $messages);
    }
}
