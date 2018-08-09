<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Message;
use App\Activity;
use App\UserSave;
use App\UserSaveObject;
use App\DeleteRequest;
use App\Tag;
use Barryvdh\DomPDF\PDF;
use App;

class MessagesController extends Controller
{
    /**
     * Shows a list of messages for the user
     *
     * @return Illuminate\View\View
     */
    public function index(Guard $auth)
    {
        // Fetch all "deleted" messages by this user
        $deletedMessagesIds = DeleteRequest::where('author_id', $auth->user()->id)
            ->where('object_type', 'App\Message')
            ->pluck('object_id')
            ->toArray();

        // Fetch all "saved" messages by this user
        $savedMessagesIds = UserSaveObject::where('object_type', 'App\Message')
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->pluck('object_id')
            ->toArray();

        //dd($savedMessagesIds);

        // Fetch messages
        $messages = Message::with([
                'comments',
                'author'
            ])
            ->where('author_id', $auth->user()->id)
            ->whereNotIn('id', $deletedMessagesIds)
            ->whereNotIn('id', $savedMessagesIds)
            ->get();

        $crosscuttingConcepts = Tag::where('type','Crosscutting Concepts')->get();
        $crosscuttingConcepts->map(function($crosscuttingConcept)
        {
            $crosscuttingConcept->name_checkbox = "crosscutting-concepts_".strtolower(str_replace(" ","-",$crosscuttingConcept->tag));

        });

        $practices = Tag::where('type','Practices')->get();
        $practices->map(function($practice)
        {
            $practice->name_checkbox = "practices_".strtolower(str_replace(" ","-",$practice->tag));

        });

        $coreIdeas = Tag::where('type','Core Ideas')->get();
        $coreIdeas->map(function($coreIdea)
        {
            $coreIdea->name_checkbox = "core-ideas_".strtolower(str_replace(" ","-",$coreIdea->tag));

        });

        return view('messages.index', [
            'page' => 'message',
            'title' => 'Messages',
            'deletedMessagesIds' => $deletedMessagesIds,
            'savedMessagesIds' => $savedMessagesIds,
            'messages' => $messages,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas
        ]);
    }

    /**
     * Performs a search and displays search results
     */
    public function search($subdomain, Guard $auth, Request $request) {
        $messages = with(new MessageRepository)->messagesForUserSearch(
            $auth->id(),
            $request->get('take', 100),
            $request->get('sort'),
            $request->get('year'),
            $request->get('month'),
            $request->get('day'),
            $request->get('author'),
            $request->get('title'),
            $request->get('search_tags')
        );

        return view('messages.search-results', [
            'page' => 'message',
            'title' => 'Messages',
            'messages' => $messages
        ]);
    }

    /**
     * Shows one message by id
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, $id)
    {
        $message = Message::findOrFail($id);

        // If the user does not have permission to view the message then return a 404 error
        if ($auth->user()->cannot('view', $message)) {
            return abort(404, 'This message either does not exist or you do not have permission to view it.');
        }

        // Check if this user has already saved this message
        /*$saved = UserSave::where('author_id', $auth->id())
            ->whereHas('object', function ($q) use ($id) {
                $q->where('object_type', 'App\Message');
                $q->where('object_id', $id);
            })->first();*/
        $isSaved = false;

        $saved = UserSaveObject::where('object_type', 'App\Message')
            ->where('object_id', $id)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->first();

        if (!empty($saved->object_id)) {
            $isSaved = true;
        }

        $requestedDelete = false;

        $deleteRequest = DeleteRequest::where('object_id', $id)
            ->where('object_type', 'App\Message')
            ->first();

        if (!empty($deleteRequest->object_id)) {
            $requestedDelete = true;
        }

        $crosscuttingConcepts = Tag::where('type','Crosscutting Concepts')->get();
        $crosscuttingConcepts->map(function($crosscuttingConcept)
        {
            $crosscuttingConcept->name_checkbox = "crosscutting-concepts_".strtolower(str_replace(" ","-",$crosscuttingConcept->tag));

        });

        $practices = Tag::where('type','Practices')->get();
        $practices->map(function($practice)
        {
            $practice->name_checkbox = "practices_".strtolower(str_replace(" ","-",$practice->tag));

        });

        $coreIdeas = Tag::where('type','Core Ideas')->get();
        $coreIdeas->map(function($coreIdea)
        {
            $coreIdea->name_checkbox = "core-ideas_".strtolower(str_replace(" ","-",$coreIdea->tag));

        });

        if ($message->author_id == $auth->user()->id && $requestedDelete == true) {
            // The author cannot view a message they requested to be deleted, however participants can
            return view('pages.system-message', [
                'page' => 'system-message',
                'title' => 'System Messages',
                'message' => 'You have requested this message to be deleted. Due to this, you can not see this message thread.'
            ]);
        } else {
            return view('messages.show', [
                'page' => 'message',
                'title' => 'Messages',
                'message' => $message,
                'saved' => $saved,
                'isSaved' => $isSaved,
                'requestedDelete' => $requestedDelete,
                'crosscuttingConcepts' => $crosscuttingConcepts,
                'practices' => $practices,
                'coreIdeas' => $coreIdeas
            ]);
        }
    }

    /**
     * Updates a message
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $message = Message::findOrFail($id);
        if ($auth->user()->cannot('update', $message)) {
            return abort(400, 'You do not have permission to edit this message');
        }

        $message->fill($request->only('title', 'content'));

        // If participants were selected for this message then add them here
        $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($request->input('participants')));

        // Attach the user participants to the message
        $message->participants()->sync($participantIds);

        $message->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'secondary');
        $request->session()->flash('flash.message', 'Your message has been successfully updated!');

        // Send the user back to the page they were on
        return redirect()->route('messages.show', [
            'subdomain' => $subdomain,
            'id' => $message->id
        ]);
    }

    /**
     * Create a new message
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Create a new message
        $message = Message::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'author_id' => $auth->id()
        ]);

        // If participants were selected for this message then add them here
        if ($participants = $request->input('participants')) {
            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));

            // Attach the user participants to the message
            $message->participants()->sync($participantIds);
        }

        // If tags were selected for this message then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the video
            $message->tags()->sync($tags);
        }

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'secondary');
        $request->session()->flash('flash.message', 'Your message has been successfully sent.');

        // Redirect the user to the message show page
        return redirect()->route('messages.show', [
            'subdomain' => $subdomain,
            'id' => $message->id
        ]);
    }

    /**
     * Destroys a message
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $message = Message::findOrFail($id);

        if ($auth->user()->cannot('destroy', $message)) {
            return abort(400, 'You do not have permission to delete this message.');
        }

        $message->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'secondary');
        $request->session()->flash('flash.message', 'The message has been successfully deleted!');

        return redirect()->route('messages.index', [
            'subdomain' => $subdomain
        ]);
    }

    public function export($subdomain, Guard $auth, Request $request, $id) {
        $message = Message::findOrFail($id);

        //dd(['Message' => $message, 'Comments' => $message->comments]);

        // Message "header"
        $export = "<h1>Message #". $message->id ." Transcript</h1>";
        $export .= "<h2>Originally written on ". $message->created_at->format("M d Y") ." at ". $message->created_at->format("g:i A") ." by ". $message->author->displayName ."</h2>";
        $export .= "<p>". $message->content ."</p>";

        $export .= "<hr />";

        // Message comments
        if (count($message->comments)) {
            foreach ($message->comments as $comment) {
                $export .= "<h2>Comment by " . $comment->author->display_name . " on " . $comment->created_at->format("M d Y") . " at " . $comment->created_at->format("g:i A");
                $export .= "<p>" . $comment->content . "</p>";
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($export);
        return $pdf->download();
    }
}
