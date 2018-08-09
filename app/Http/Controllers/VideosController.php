<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Exemplar;
use App\Repositories\UserRepository;
use App\Tag;
use App\VideoDiscussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\VideoRepository;
use App\Repositories\GroupRepository;
use App\Video;
use Illuminate\Support\Collection;
use Mail;
use App\User;
use App\VideoCategory;
use App\VideoColumn;
use App\VideoColumnObject;
use App\UserShare;
use App\UserShareObject;
use App\UserSave;
use Illuminate\Support\Facades\DB;
use App\UserSaveObject;
use App\DeleteRequest;
use App\RecoverRequest;
use App\VideoDeleted;

class VideosController extends Controller
{
    /**
     * Shows a list of videos in the video center
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request) {
        $videos = with(new VideoRepository)->videosForUser(
            $request->get('take', 10),
            $request->get('sort')
        );

        // Get all video categories
        //$videoCategories = VideoCategory::get();

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

        // Shared videos are videos the user is tagged in/participating
        $sharedVideos = with(new VideoRepository)->videosForUserParticipatingAndSharedWith(
        //$sharedVideos = with(new VideoRepository)->videosForUserParticipating(
            $auth->id(),
            $request->get('take', 50),
            $request->get('sort')
        );

        // Get saved videos
        /*$savedVideoIds = UserSave::where('author_id', $auth->user()->id)
            ->whereHas('userSaveObject')
            ->get()
            ->pluck('object_id')
            ->toArray();*/
        $savedVideos = UserSaveObject::where('object_type', Video::class)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->get();

        $savedVideosById = [];
        if (count($savedVideos)) {
            foreach($savedVideos as $savedVideo) {
                $savedVideosById[$savedVideo->object_id] = $savedVideo;
            }
        }

        //dd($savedVideosById);

        $savedVideos = Video::with([
                //'comments',
                //'comments.author',
                //'annotations',
                //'annotations.author',
                'author',
                'participants',
                'tags'])
            ->whereIn('id', $savedVideos->pluck('object_id'))
            ->get();

        $savedVideos = $savedVideos->sortByDesc(function($savedVideo) use($savedVideosById) {
            return $savedVideosById[$savedVideo->id]['created_at'];
        });

        //dd($savedVideos);

        return view('video-center.index', [
            'page' => 'video-center',
            'title' => 'Video Center',
            'videos' => $videos,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            //'videoCategories' => $videoCategories,
            'sharedVideos' => $sharedVideos,
            'savedVideos' => $savedVideos
        ]);
    }

    /**
     * Searches for videos with the given criteria
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     */
    public function search($subdomain, Guard $auth, Request $request) {
        $textInfo = "";

        $videos = with(new VideoRepository)->videosForUserSearch(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort'),
            $request->get('search_tags'),
            $request->get('year'),
            $request->get('month'),
            $request->get('day'),
            $request->get('author'),
            $request->get('title')
        );

        // Get all video categories
        //$videoCategories = VideoCategory::get();

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

        // Get shared videos
        $sharedVideos = UserShare::where('recipient_id', $auth->user()->id)
            ->get();

        // Get saved videos
        $savedVideos = UserSave::where('author_id', $auth->user()->id)
            ->get();

        // Build prefilled array
        $prefilled = [];

        if ($request->has('author') && is_array($request->get('author'))) {
            // Fetch author names
            $prefilled['author'] = with(new UserRepository)->getUsers($request->get('author'));
        }

        if ($request->has('search_tags') && is_array($request->get('search_tags'))) {
            // Fetch tags
            $prefilled['tags'] = Tag::whereIn('id', $request->get('search_tags'))->get();
        }

        return view('video-center.index', [
            'page' => 'video-center',
            'title' => 'Video Center',
            'videos' => $videos,
            'resultFor' => $textInfo,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            //'videoCategories' => $videoCategories,
            'sharedVideos' => $sharedVideos,
            'savedVideos' => $savedVideos,
            'prefilled' => $prefilled
        ]);
    }

    /**
     * Updates a video
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);
        if ($auth->user()->cannot('update', $video)) {
            return abort(400, 'You do not have permission to edit this video');
        }

        $video->fill($request->only('title', 'content', 'description'));

        $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect( $request->input('participants')));

        // Attach the user participants to the video
        $video->participants()->sync($participantIds);

        // If tags were selected for this video then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the video
            $video->tags()->sync($tags);
        } else {
            $video->tags()->detach();
        }

        $video->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your video has been successfully updated.');

        // Send the user back to the page they were on
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $video->id
        ]);
    }

    /**
     * Shows one video by id
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, Request $request, $id, $participantId = 0) {
        // Fetch video
        $video = Video::findOrFail($id);

        // Fetch tags associated to video
        $videoTags = collect($video->tags)->pluck('tag')->toArray();

        // If no participant is supplied, we'll assume the currently logged in user
        if ($participantId == 0) {
            $participantId = $auth->user()->id;
        }

        // Fetch progress bars that have been shared with this user
        $videoColumnsSharedIds = UserShareObject::where('object_type', 'App\\VideoColumn')
            ->whereHas('userShare', function($q) use ($auth) {
                $q->where('recipient_id', $auth->user()->id);
            })
            ->get()
            ->pluck('object_id');
        
        // Fetch columns (if any)
        $videoColumns = VideoColumn::where('video_id', $id)->orderBy('created_at')->get();

        // If any shared video columns, include them in the query
        if (count($videoColumnsSharedIds) > 0) {
            $videoColumnsShared = VideoColumn::whereIn('video_id', $videoColumnsSharedIds)->get();

            foreach ($videoColumnsShared as $vcShareIndex => $vcShare) {
                $videoColumnsShared[$vcShareIndex]['is_shared'] = true;
            }

            // Merge into $videoColumns
            $videoColumns->merge($videoColumnsShared);
        }

        $videoColumnAnnotations = [];

        // Fetch video column objects and their annotations
        if (count($videoColumns)) {
            foreach ($videoColumns as $videoColumn) {
                if (count($videoColumn->objects)) {
                    foreach ($videoColumn->objects as $videoColumnObject) {
                        $ann = Annotation::with('author')->where('id', '=', $videoColumnObject->object_id)->get()->toArray();
                        $ann[0]['video_column_object_id'] = $videoColumnObject->id;

                        $videoColumnAnnotations[$videoColumn->id][] = $ann;
                    }
                }
            }
        }

        $videoColumnAnnotationsCollection = collect($videoColumnAnnotations);

        // Create list of "Shared with" people (from logged in user to other users)
        $sharedWith = UserShare::with('object')
            ->where('author_id', $auth->user()->id)
            ->whereHas('object', function($q) use($id) {
                $q->where('object_id', $id);
            })
            ->get();

        $sharedWithList = [];

        if ($sharedWith->count() > 0) {
            foreach ($sharedWith as $sharedVideo) {
                $sharedWithList[$sharedVideo->id] = User::where('id', $sharedVideo->recipient_id)->first();
            }
        }

        /*$sharedVideosIds = UserShareObject::where('object_type', Video::class)
            ->where('object_id', $id)
            ->whereHas('userShare', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->get();

        if (count($sharedVideosIds)) {
            $sharedWith = [];

            foreach ($sharedVideosIds as $sharedVideo) {
                dump($sharedVideo);
                $sharedWith[$sharedVideo->id] = $sharedVideo->recipient_id;
            }
        }*/

        //dd($sharedWith);

        // If the user does not have permission to view the video then return a 404 error
        if ($auth->user()->cannot('view', $video)) {
            return abort(404, 'This video either does not exist or you do not have permission to view it.');
        }

//        if ($video->belongsTo($auth->user())) {
//            //
//        } else {
//            return abort(404, 'This video either does not exist or you do not have permission to view it.');
//        }

        $crosscuttingConcepts = Tag::where('type','Crosscutting Concepts')->get();
        $crosscuttingConcepts->map(function($crosscuttingConcept) {
            $crosscuttingConcept->name_checkbox = "crosscutting-concepts_".strtolower(str_replace(" ","-",$crosscuttingConcept->tag));

        });

        $practices = Tag::where('type','Practices')->get();
        $practices->map(function($practice) {
            $practice->name_checkbox = "practices_".strtolower(str_replace(" ","-",$practice->tag));

        });

        $coreIdeas = Tag::where('type','Core Ideas')->get();
        $coreIdeas->map(function($coreIdea) {
            $coreIdea->name_checkbox = "core-ideas_".strtolower(str_replace(" ","-",$coreIdea->tag));

        });

        // Fetch annotations for appropriate user
        $annotationsModel = $video->annotations()->where('author_id', $participantId)->/*with('author')->*/get();
        $annotations = $annotationsModel->toJson();

        // Saved
        $isSaved = false;

        $saved = UserSaveObject::where('object_type', 'App\\Video')
            ->where('object_id', $id)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->first();

        if (!empty($saved->object_id)) {
            //$savedID = $saved->user_save_id;
            $isSaved = true;
        }

        /*// Request Delete
        $requestedDelete = false;

        $deleteRequest = DeleteRequest::where('object_id', $id)
            ->where('object_type', 'App\\Video')
            ->first();

        if (!empty($deleteRequest->object_id)) {
            $requestedDelete = true;
        }

        // Pending Mode (used for Pending Requests/Exemplars)
        $pendingMode = $request->input('pendingMode');

        // Delete Mode (used for Pending Requests/Delete)
        $deleteMode = $request->input('deleteMode');
        $deleteId = $request->input('deleteId');

        // Recover Mode (used for Pending Requests/Recover)
        $recoverMode = $request->input('recoverMode');
        $recoverId = $request->input('recoverId');

        // Request Delete
        $requestedRecover = false;

        $recoverRequest = RecoverRequest::where('object_id', $id)
            ->where('object_type', 'App\\Video')
            ->first();

        if (!empty($recoverRequest->object_id)) {
            $requestedRecover = true;
        }*/

        // Fetch discussions
        $discussions = VideoDiscussion::with([
                'originalAnnotation',
                'questions',
                'annotations',
                'annotations.associatedAnnotation',
                'participants']
        )->where('video_id', $id)
            ->has('questions', '>', '0'); // This ensures we only fetch discussions with questions

        // If the user is a coach/MT or higher, they can see all discussions
        if ($auth->user()->isEither(['master_teacher', 'super_admin', 'project_admin', 'coach', 'mod'])) {
            // We're good, continue
        } else {
            // Only fetch discussions the user is a participant of
            $discussions->participating($auth->user()->id);
        }

        $discussions = $discussions->orderBy('created_at')
                        ->get();

        return view('video-center.show', [
            'page' => 'video',
            'title' => 'Video Center',
            'video' => $video,
            'videoTags' => $videoTags,
            'annotations' => $annotations,
            'annotationsModel' => $annotationsModel,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            'videoColumns' => $videoColumns,
            'videoColumnsList' => $videoColumns,
            'videoColumnAnnotations' => $videoColumnAnnotationsCollection,
            'videoColumnsSharedIds' => $videoColumnsSharedIds,
            'isSaved' => $isSaved,
            'discussions' => $discussions,
            /*'requestedDelete' => $requestedDelete,
            'deleteRequest' => $deleteRequest,
            'pendingMode' => $pendingMode,
            'deleteMode' => $deleteMode,
            'deleteId' => $deleteId,
            'recoverMode' => $recoverMode,
            'recoverId' => $recoverId,
            'requestedRecover' => $requestedRecover,
            'recoverRequest' => $recoverRequest,*/
            'viewingParticipantId' => $participantId,
            'sharedWithList' => $sharedWithList
        ]);
    }

    /**
     * Create a new video
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video
        if ($auth->user()->cannot('create', new Video)) {
            return abort(400, 'You do not have permission to create a new video');
        }

        // Check if category ID was passed
        $categoryId = $request->has('category_id') ? $request->get('category_id') : '0';

        // Check if we need to create a new category
        if ($categoryId == 'new') {
            // Create new category
            $newCategory = new VideoCategory;
            $newCategory->name = $request->get('new_category_name');

            // Save new category to the DB
            $newCategory->save();

            // Add new category ID to the post data
            $categoryId = $newCategory->id;
        }

        // Create a new video
        $video = Video::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'content' => $request->get('content'),
            'author_id' => $auth->id(),
            'wistia_id' => $request->get('wistia_id'),
            'wistia_hashed_id' => $request->get('wistia_hashed_id'),
            'wistia_duration' => $request->get('wistia_duration'),
            'wistia_thumbnail' => $request->get('wistia_thumbnail'),
            'cat_id' => $categoryId,
//            'hidden' => 1
        ]);

        // If participants were selected for this video then add them here
        //if ($participants = $request->input('participants')) {

        $currentAuthor = User::where('id',$auth->user()->id)->firstOrFail();

        //Super Admins don't share with themselves
        if ($currentAuthor->role_id == '6') {

        //Teachers have their videos shared with their Coach (Master Teacher) and Super Admin (ID: 1)
        } elseif ($currentAuthor->role_id == '2') {
            $participants = collect([$currentAuthor->masterteacher,'1']);
            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));
            $video->participants()->sync($participantIds);
        //Everyone else just shares it with Super Admin
        } else {
            $participants = collect(['1']);
            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));
            $video->participants()->sync($participantIds);
        }



        //}
        
        // If tags were selected for this video then add them here
        if ($tags = $request->input('tags')) {

            // Attach the tags to the video
            $video->tags()->sync($tags);
            
        }

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.status', 'uploaded');
        $request->session()->flash('flash.message', 'Your video has successfully been uploaded and is currently being converted to streaming format.');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $video->id
        ]);
    }

    /**
     * Hide a video an all the information without Destroy it
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if ($auth->user()->cannot('destroy', $video)) {
            return abort(400, 'You do not have permission to delete this video');
        }

        $video->hidden = 1;
        $video->save();

        $sharedWith = UserShare::with('object')
            ->whereHas('object', function($q) use($id) {
                $q->where('object_id', $id);
            })
            ->get()
            ->pluck('recipient_id')
            ->toArray();

        // Include video author
        $sharedWith[] = $video->author_id;

        $video->participants()->attach($sharedWith);
        $video->record('deleted');

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'The video has been successfully deleted.');

        return redirect()->route('video-center.index', [
            'subdomain' => $subdomain,
        ]);
    }

    /**
     * Shows a list of videos waiting for be exemplar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function exemplars($subdomain, Guard $auth, Request $request)
    {
        $exemplars = with(new VideoRepository)->videosWaitingForApprove(
            $auth->id(),20);

        $video = Video::first();
        if ($auth->user()->cannot('exemplars', $video)) {
            return abort(404, 'This page does not exist or you do not have permission to view it.');
        }

        return view('video-center.exemplars', [
            'page' => 'video-center',
            'title' => 'Video Center',
            'exemplars' => $exemplars
        ]);
    }

    public function pending($subdomain, Guard $auth, Request $request) {
        $pendingResources = with(new VideoRepository)->videosWaitingForApprove($auth->id(), 20);
        $pendingRecovered = RecoverRequest::with('author')
            ->where('object_type', 'App\Video')
            ->where('approved', '0')
            ->where('recoverer_id', '0') // "Denied" requests have a Deleter ID
            ->get();
        $pendingDeleted = DeleteRequest::with('author')
            ->where('object_type', 'App\Video')
            ->where('approved', '0')
            ->where('deleter_id', '0') // "Denied" requests have a Recoverer ID
            ->get();

        if ($pendingRecovered->count() > 0) {
            foreach ($pendingRecovered as $rIndex => $rRecord) {
                $pendingRecovered[$rIndex]['video'] = Video::find($rRecord->object_id);
            }
        }

        if ($pendingDeleted->count() > 0) {
            foreach ($pendingDeleted as $dIndex => $dRecord) {
                $pendingDeleted[$dIndex]['video'] = Video::find($dRecord->object_id);
            }
        }

        /*$video = Video::first();
        if ($auth->user()->cannot('exemplars', $video)) {
            return abort(404, 'This page does not exist or you do not have permission to view it.');
        }*/

        return view('video-center.pending', [
            'page' => 'video-center',
            'title' => 'Video Center',
            'pendingResources' => $pendingResources,
            'pendingRecovered' => $pendingRecovered,
            'pendingDeleted' => $pendingDeleted
        ]);
    }

    /*public function pendingDeleteApprove($subdomain, Guard $auth, Request $request, $id) {
        $deleteRequest = DeleteRequest::where('id', $id);

        $deleteRequest->update(['approved' => '1', 'deleter_id' => $auth->user()->id]);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This video has been approved to be deleted.');

        return redirect('video-center');
    }

    public function pendingDeleteDeny($subdomain, Guard $auth, Request $request, $id) {
        $deleteRequest = DeleteRequest::where('id', $id);

        $deleteRequest->update(['approved' => '0', 'deleter_id' => $auth->user()->id]);

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'This video delete request has been denied.');

        return redirect('video-center');
    }*/

    /**
     * Send and email to super_admin with the error returned by Wistia
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function emailError($subdomain, Guard $auth, Request $request)
    {
        if($request->has('content'))
        {

            $error = $request->get('content');
            $superAdmin = User::find(1);

            $user = $auth->user();
            $role = $user->role;
            Mail::send('emails.error.video', compact('role', 'user', 'error'), function ($m) use ($role, $user,$error, $superAdmin) {
                $m->from('support@earlyscienceinitiative.org', 'Early Science Initiative');
                $m->to($superAdmin->email, 'Super Admin')->subject("Error received from Wistia");
            });

        }
    }

    /**
     * Saves a column to this video
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeColumn($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video column
        /*if ($auth->user()->cannot('create', new VideoColumn)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new column
        $videoColumn = VideoColumn::create([
            'video_id' => $request->get('video_id'),
            'author_id' => $auth->user()->id,
            'name' => $request->get('column_name'),
            'color' => $request->get('column_color')
        ]);

        // Check if there was an annotation ID passed
        if ($request->has('annotation_id')) {
            // Add annotation to the newly created column
            VideoColumnObject::create([
                'video_column_id' => $videoColumn->id,
                'object_id' => $request->get('annotation_id'),
                'object_type' => 'App\\Annotation',
            ]);
        }

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your column has been added.');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id'),
            '#columns-list'
        ]);
    }

    /**
     * Updates a video
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function updateColumn($subdomain, Guard $auth, Request $request)
    {
        /*$video = Video::findOrFail($id);
        if ($auth->user()->cannot('update', $video)) {
            return abort(400, 'You do not have permission to edit this video');
        }*/

        $videoColumn = VideoColumn::findOrFail($request->get('column_id'));

        $videoColumn->fill([
            'name' => $request->get('column_name'),
            'color' => $request->get('column_color')
        ]);

        $videoColumn->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your column has been successfully updated.');

        // Send the user back to the page they were on
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id'),
            '#columns-list'
        ]);
    }

    /**
     * Hide a video an all the information without Destroy it
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroyColumn($subdomain, Guard $auth, Request $request)
    {
        $videoColumn = VideoColumn::findOrFail($request->get('column_id'));

        /*if ($auth->user()->cannot('destroy', $video)) {
            return abort(400, 'You do not have permission to delete this video');
        }*/

        $videoColumn->destroy($request->get('column_id'));

        // Show a success message
        /*$request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'The column has been successfully deleted.');*/

        /*return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id')
        ]);*/
        return response(200);
    }

    public function storeAddToColumn($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video column
        /*if ($auth->user()->cannot('create', new VideoColumn)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new cycle step
        $videoColumnObject = VideoColumnObject::create([
            'video_column_id' => $request->get('column_id'),
            'object_id' => $request->get('object_id'),
            'object_type' => $request->get('object_type'),
        ]);

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your annotation has been added to the selected column.');

        // Redirect the user to the video show page
        /*return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id')
        ]);*/
        return ['videoColumnObjectId' => $videoColumnObject->id];
    }

    public function destroyObjectInColumn($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video column
        /*if ($auth->user()->cannot('create', new VideoColumn)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new cycle step
        $videoColumnObject = VideoColumnObject::where('video_column_id', $request->get('column_id'))->where('id', $request->get('object_id'));

        $videoColumnObject->delete();

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your annotation has been removed from the selected column.');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id')
        ]);
    }

    public function listVideosByAuthorId($subdomain, Guard $auth, Request $request, $authorId) {
        $textInfo = "";

        $videos = with(new VideoRepository)->videosForUserByAuthor(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort'),
            '',
            $authorId
        );

        // Get all video categories
        $videoCategories = VideoCategory::get();

        $crosscuttingConcepts = Tag::where('type','Crosscutting Concepts')->get();
        $crosscuttingConcepts->map(function($crosscuttingConcept) {
            $crosscuttingConcept->name_checkbox = "crosscutting-concepts_".strtolower(str_replace(" ","-",$crosscuttingConcept->tag));

        });

        $practices = Tag::where('type','Practices')->get();
        $practices->map(function($practice) {
            $practice->name_checkbox = "practices_".strtolower(str_replace(" ","-",$practice->tag));

        });

        $coreIdeas = Tag::where('type','Core Ideas')->get();
        $coreIdeas->map(function($coreIdea) {
            $coreIdea->name_checkbox = "core-ideas_".strtolower(str_replace(" ","-",$coreIdea->tag));

        });

        // Shared videos are videos the user is tagged in/participating
        $sharedVideos = with(new VideoRepository)->videosForUserParticipating(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort')
        );

        // Get saved videos
        $savedVideos = UserSave::where('author_id', $auth->user()->id)
            ->get();

        return view('video-center.index', [
            'page' => 'video-center',
            'title' => 'Video Center',
            'videos' => $videos,
            'resultFor' => $textInfo,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            'videoCategories' => $videoCategories,
            'sharedVideos' => $sharedVideos,
            'savedVideos' => $savedVideos
        ]);
    }
}
