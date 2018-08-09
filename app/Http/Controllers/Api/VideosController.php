<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\VideoRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use stdClass;

use App\Video;
use App\VideoDiscussion;

class VideosController extends Controller
{
    /**
     * Lists out videos and allows the user to search
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, Request $request)
    {
        /*$videos = with(new VideoRepository)->videosForUserParticipatingAndSharedWith_Raw(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort', 'desc')
        );*/

        $videos = with(new VideoRepository)->videosForUser(
            $request->get('take', 10),
            $request->get('sort')
        );

        //dump($videos);

        /*$videos->getCollection()->map(function($video)
        {
            $video->avatar = $video->author->avatar->url();
        });*/

        return ['results' => $videos->items()];
    }

    /**
     * Lists out video discussions
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function showDiscussions($subdomain, Guard $auth, Request $request)
    {

        $discussions = VideoDiscussion::with([
            'video'
        ])->get();

        //dd($discussions);

        $activeDiscussions = collect([]);

        if ($discussions->count() > 0) {
            foreach ($discussions as $discussion) {
                if (!is_null($discussion->video)) {
                    if (!empty($discussion->video->title) && !empty($discussion->video->url)) {
                        // Fetch the video
                        //$video = Video::findOrFail($discussion->video->id);

                        $discussion->title = $discussion->video->title . ': ' . $discussion->title;
                        $discussion->link = $discussion->video->url .'?discussionId='. $discussion->id .'#openDiscussion';

                        //dump($discussion);

                        $activeDiscussions->push($discussion);
                    }
                }
            }
        }

        /*$discussions = $discussions->map(function($discussion) {
            $discussion->list_name = $discussion->video()->title .': '. $discussion->title;
        });*/

        return ['results' => $activeDiscussions];
    }

    public function searchTitle($subdomain, Guard $auth, Request $request)
    {
        $videos = with(new VideoRepository)->videosForUser_TitleSearch(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );

        $videos->getCollection()->map(function($video)
        {
            $video->avatar = $video->author->avatar->url();
        });

        return ['results' => $videos->items()];
    }

    public function searchAuthor($subdomain, Guard $auth, Request $request)
    {
        $output = [];

        /*$videos = with(new VideoRepository)->videosForUser_AuthorSearch(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );

        $videos->getCollection()->map(function($video)
        {
            $video->avatar = $video->author->avatar->url();
        });

        return ['results' => $videos->items()];*/

        $users = with(new UserRepository)->getVisibleUsers(
            $auth->user(),
            $request->get('q')
        );

        //dd($users->toArray());

        /*$users->map(function($user)
        {
            $user->avatar = $user->avatar->url();
        });*/

        //dd($users->toArray());

        foreach ($users as $user) {
            $obj = new stdClass;
            $obj->id = $user->id;
            $obj->text = $user->display_name;
            $output[] = $obj;
        }

        return ['results' => collect($output)->values()];

        /*return [
            'results' => $users
        ];*/
    }
}
