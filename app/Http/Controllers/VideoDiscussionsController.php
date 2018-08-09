<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests;

use App\Video;
use App\VideoDiscussion;
use App\VideoDiscussionAnnotation;
use App\VideoDiscussionQuestion;
use App\VideoDiscussionQuestionAnswer;

use App\UserShare;

use App\Comment;

use App\Repositories\GroupRepository;

class VideoDiscussionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        $multipleAnnotations = $request->has('annotation_ids') && is_array($request->get('annotation_ids'));

        // Single annotation or no annotation
        if (!$multipleAnnotations) {
            // Create new video discussion
            $videoDiscussion = VideoDiscussion::create([
                'author_id' => $auth->user()->id,
                'video_id' => $id,
                'annotation_id' => $request->get('annotation_id'),
                'title' => $request->get('title'),
                'annotation' => $request->get('message')
            ]);

            $video = Video::findOrFail($id);

            // Associate author of video discussion as well
            $videoDiscussion->participants()->attach($auth->user()->id);

            if ($participants = $request->input('participants')) {
                $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));

                //dd($participantIds);

                // Attach the user participants to the video
                $videoDiscussion->participants()->attach($participantIds);
            }

            $questions = $request->get('question');

            // Create questions
            if (is_array($questions)) {
                // Create the new questions
                foreach ($questions as $question) {
                    $videoDiscussionQuestion = VideoDiscussionQuestion::create([
                        'video_id' => $id,
                        'video_discussion_id' => $videoDiscussion->id,
                        'author_id' => $auth->user()->id,
                        'question' => $question
                    ]);
                }
            }

            // Fetch list of all people this video has been shared with + send notification
            $sharedWith = UserShare::with('object')
                ->whereHas('object', function ($q) use ($id) {
                    $q->where('object_id', $id);
                })
                ->get()
                ->pluck('recipient_id')
                ->toArray();

            // Include video author
            $sharedWith[] = $video->author_id;

            // @TODO: Disabled due to video discussion notification bug + associating too many people to each discussion
            $videoDiscussion->participants()->attach($sharedWith);
            $videoDiscussion->record();
        } else {
            // Create discussion + associate with multiple annotations

            // Create new video discussion
            $videoDiscussion = VideoDiscussion::create([
                'author_id' => $auth->user()->id,
                'video_id' => $id,
                'annotation_id' => $request->get('annotation_id'),
                'title' => $request->get('title'),
                'annotation' => $request->get('message')
            ]);

            $video = Video::findOrFail($id);

            if ($participants = $request->input('participants')) {
                $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));

                //dd($participantIds);

                // Attach the user participants to the video
                $videoDiscussion->participants()->sync($participantIds);
            }

            // Associate annotations
            foreach ($request->get('annotation_ids') as $annotationId) {
                $videoDiscussionAnnotation = VideoDiscussionAnnotation::create([
                    'discussion_id' => $videoDiscussion->id,
                    'annotation_id' => $annotationId
                ]);
            }

            $questions = $request->get('question');

            // Create questions
            if (is_array($questions)) {
                // Create the new questions
                foreach ($questions as $question) {
                    $videoDiscussionQuestion = VideoDiscussionQuestion::create([
                        'video_id' => $id,
                        'video_discussion_id' => $videoDiscussion->id,
                        'author_id' => $auth->user()->id,
                        'question' => $question
                    ]);
                }
            }

            // Fetch list of all people this video has been shared with + send notification
            $sharedWith = UserShare::with('object')
                ->whereHas('object', function ($q) use ($id) {
                    $q->where('object_id', $id);
                })
                ->get()
                ->pluck('recipient_id')
                ->toArray();

            // Include video author
            $sharedWith[] = $video->author_id;

            // @TODO: Disabled due to video discussion notification bug + associating too many people to each discussion
            $videoDiscussion->participants()->attach($sharedWith);
            $videoDiscussion->record();
        }

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your discussion has been successfully created!');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function storeResponse($subdomain, Guard $auth, Request $request, $id) {
        // Get discussion
        $discussion = VideoDiscussion::findOrFail($request->get('discussion_id'));

        // Fetch list of all people this video has been shared with + send notification
        $sharedWith = UserShare::with('object')
            ->whereHas('object', function($q) use($discussion) {
                $q->where('object_id', $discussion->video_id);
            })
            ->get()
            ->pluck('recipient_id')
            ->toArray();

        // Include video author
        $sharedWith[] = $discussion->video->author_id;

        // Create new answer for the given questions
        foreach ($request->get('answers') as $questionId => $answer) {
            // Delete previous drafts for this question
            $previousDrafts = VideoDiscussionQuestionAnswer::where('author_id', $auth->user()->id)
                ->where('video_discussion_id', $request->get('discussion_id'))
                ->where('question_id', $questionId)
                ->where('is_draft', '1')
                ->delete();

            // Add to the database
            $questionResponse = VideoDiscussionQuestionAnswer::create([
                'author_id' => $auth->user()->id,
                'video_discussion_id' => $request->get('discussion_id'),
                'video_discussion_question_id' => $questionId,
                'question_id' => $questionId,
                'answer' => $answer
            ]);

            $questionResponse->participants()->attach($sharedWith);
            $questionResponse->record('response');
        }

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your response to this discussion has been successfully saved!');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function storeSaveDraft($subdomain, Guard $auth, Request $request, $id) {
        // Get discussion
        $discussion = VideoDiscussion::findOrFail($request->get('discussion_id'));

        // Create new answer draft for the given questions
        foreach ($request->get('answers') as $questionId => $answer) {
            // Delete previous drafts for this question
            $previousDrafts = VideoDiscussionQuestionAnswer::where('author_id', $auth->user()->id)
                ->where('video_discussion_id', $request->get('discussion_id'))
                ->where('question_id', $questionId)
                ->where('is_draft', '1')
                ->delete();

            // Add to the database
            $questionResponse = VideoDiscussionQuestionAnswer::create([
                'author_id' => $auth->user()->id,
                'video_discussion_id' => $request->get('discussion_id'),
                'video_discussion_question_id' => $questionId,
                'question_id' => $questionId,
                'answer' => $answer,
                'is_draft' => '1'
            ]);
        }

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your draft response to this discussion has been successfully saved. Only you can see your draft, edit it and publish it.');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function storeResponseToAnswer($subdomain, Guard $auth, Request $request, $id) {
        // Get the discussion question answer
        $discussionQuestionAnswer = VideoDiscussionQuestionAnswer::findOrFail($request->get('answer_id'));
        $discussion = VideoDiscussion::findOrFail($discussionQuestionAnswer->video_discussion_id);

        // Create new comment
        $discussionQuestionAnswer->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        // Fetch list of all people this video has been shared with + send notification
        $sharedWith = UserShare::with('object')
            ->whereHas('object', function($q) use($discussion) {
                $q->where('object_id', $discussion->video_id);
            })
            ->get()
            ->pluck('recipient_id')
            ->toArray();

        // Include video author
        $sharedWith[] = $discussion->video->author_id;

        $discussionQuestionAnswer->participants()->attach($sharedWith);
        $discussionQuestionAnswer->record('comment');

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'You have successfully responded to that discussion question!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $discussion = VideoDiscussion::findOrFail($id);

        $discussion->fill($request->only('title'));

        // Update questions?
        if ($request->has('question')) {
            // Loop through each question
            //dd($request->get('question'));
            foreach ($request->get('question') as $questionId => $question) {
                // Fetch question
                $questionObject = VideoDiscussionQuestion::find($questionId);

                if ($questionObject) {
                    // Update title
                    $questionObject->question = $question;

                    $questionObject->save();
                } else {
                    VideoDiscussionQuestion::create([
                        'video_id' => $discussion->video_id,
                        'video_discussion_id' => $discussion->id,
                        'author_id' => $auth->user()->id,
                        'question' => $question
                    ]);
                }
            }
        }

        // Any questions to delete?
        if ($request->has('deleteQuestion')) {
            // Loop through each ID to delete
            foreach ($request->get('deleteQuestion') as $questionIdToDelete) {
                $questionToDelete = VideoDiscussionQuestion::find($questionIdToDelete);
                $questionToDelete->delete();
            }
        }

        // Participants
        if ($participants = $request->input('participants')) {
            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));
            
            // Attach the user participants to the video
            $discussion->participants()->sync($participantIds);
        }

        $discussion->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your discussion has been successfully updated.');

        // Send the user back to the page they were on
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $discussion->video_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $discussion = VideoDiscussion::where('id', $id);

        $discussion->delete();

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAnswer($subdomain, Guard $auth, Request $request, $id)
    {
        $answer = VideoDiscussionQuestionAnswer::where('id', $id);

        $answer->delete();

        return response(200);
    }
}
