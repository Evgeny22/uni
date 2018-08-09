<?php

namespace App\Repositories;

use App\Exemplar;
use App\Tag;
use Illuminate\Contracts\Auth\Guard;
use App\Video;
use App\User;
use App\Document;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\UserShare;
use App\UserShareObject;
use App\DeleteRequest;
use Illuminate\Support\Facades\Auth;

class VideoRepository
{
    public $deletedVideos = [];
    public $deletedVideoIds = [];

    public function __construct() {
        // Load deleted videos into memory
        /*$this->deletedVideos = DeleteRequest::where('object_type', Video::class)
            ->where('approved', '1')
            ->get();

        $this->deletedVideoIds = $this->deletedVideos->pluck('object_id')->toArray();*/
    }

    /**
     * Get the latest videos for a user
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUser($take = 10, $sort = 'desc', $query = '') {
        // Get the user that is logged in
        //$user = User::find($id);

        // If $sort is exemplar only load exemplar videos
        if ($sort == 'exemplar') {
            $videos = Video::whereHas('exemplars', function ($query) {
                $query->where('approved', 1);
            })->where('hidden',0)->with([
                    //'comments',
                    //'comments.author',
                    //'annotations',
                    //'annotations.author',
                    'author',
                    'participants',
                    'tags']
            );
        } else {
            // Setup the query for retrieving a user's videos
            $videos = Video::with([
                    //'comments',
                    //'comments.author',
                    //'annotations',
                    //'annotations.author',
                    'author',
                    'participants',
                    'tags'
            ])->where('hidden',0);

            // If a search query is provided then find a video by title or author
            if ($query) {
                $videos->searchTitleOrAuthor($query);
            }
        }

        // Exclude deleted videos (if any)
        if (count($this->deletedVideoIds)) {
            $videos->whereNotIn('id', $this->deletedVideoIds);
        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored
        //if (!Auth::user()->isEither(['project_admin', 'super_admin'])) {
            //$videos->authoredOrParticipatingExemplar($user->id);
            $videos->authoredBy(Auth::user()->id);
        //}

        $videos->orderBy('created_at', $sort);

        return $videos->paginate($take);
    }

    /**
     * Get the videos a user is participating in
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserParticipating($id, $take = 10, $sort = 'desc', $query = '') {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
            'comments',
            'comments.author',
            'annotations',
            'annotations.author',
            'author',
            'participants',
            'tags'
        ])->where('hidden',0)->participating($user->id)->orderBy('created_at', $sort);

        //$videos->participating($user->id);

        return $videos->paginate($take);
    }

    /**
     * Get the videos a user is participating in and has had shared with
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserParticipatingAndSharedWith($id, $take = 10, $sort = 'desc', $query = '') {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
            //'comments',
            //'comments.author',
            //'annotations',
            //'annotations.author',
            'author',
            'participants',
            'tags'
        ])->where('hidden',0)->participating($user->id)->orderBy('created_at', $sort);

        // Fetch videos that have been shared with this user
        $sharedVideosIds = UserShareObject::where('object_type', Video::class)
            ->whereHas('userShare', function($q) use ($id) {
                $q->where('recipient_id', $id);
            })
            ->get()
            ->pluck('object_id');

        if (count($sharedVideosIds)) {
            $videos->orWhereIn('id', $sharedVideosIds);
        }

        // Exclude deleted videos (if any)
        if (count($this->deletedVideoIds)) {
            $videos->whereNotIn('id', $this->deletedVideoIds);
        }

        return $videos->paginate($take);
    }

    /**
     * Get the latest videos for a user by tag
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserSearch($id, $take = 10, $sort = 'desc', $tags = [], $year = '', $month = '', $day = '', $author = '', $title = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        if (!$tags) {
            // Setup the query for retrieving a user's videos
            $videos = Video::with([//'comments',
                    //'comments.author',
                    //'annotations',
                    //'annotations.author',
                    'author', 'participants', 'tags'])->orderBy('updated_at', $sort);
        } else {
            // If a search query is provided then find learning modules by title

            //$tags = explode(',', $tags);
            $videos = Video::all()->keyBy('id');
            $collection = $videos;

            foreach ($tags as $tag_id) {
                $tag = Tag::where('id', $tag_id)->first();

                if ($tag != null) {
                    $intersect = $collection->intersect($tag->videos->keyBy('id'));
                } else {
                    $intersect = $collection->intersect([]);
                }

                $videos = $intersect;
            }

            $ids = $videos->keyBy('id')->keys();
            $videos = Video::whereIn('id', $ids)->with([
                    //'comments',
                    //'comments.author',
                    //'annotations',
                    //'annotations.author',
                    'author',
                    'participants',
                    'tags']
            )->where('hidden',0)->orderBy('updated_at', $sort);
        }

        if ($year) {
            $videos->where(DB::raw('YEAR(created_at)'), '=', $year);
        }

        if ($month) {
            $videos->where(DB::raw('MONTH(created_at)'), '=', $month);
        }

        if ($day) {
            $videos->where(DB::raw('DAY(created_at)'), '=', $day);
        }

        if ($author) {
            /*$videos->where(function($q) use ($author) {
                $q->whereHas('author', function ($q) use ($author) {
                    $q->where('name', 'LIKE', "%$author%");
                    $q->orWhere('nickname', 'LIKE', "%$author%");
                });
            });*/
            $videos->whereIn('author_id', $author);
        }

        if ($title) {
            $videos->where(function($q) use ($title) {
                $q->where(DB::raw('title'), 'LIKE', '%'. $title .'%')
                    ->orWhere(DB::raw('description'), 'LIKE', '%'. $title .'%');
            });
        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }

    /**
     * ===========================================================================
     * All functions below are deprecated/not used
     * ===========================================================================
     */

    /**
     * Get the latest videos for a user by tag
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserByTag($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
                //'comments',
                //'comments.author',
                //'annotations',
                //'annotations.author',
                'author',
                'participants',
                'tags']
        )->orderBy('updated_at', $sort);

        if ($query) {
            // If a search query is provided then find learning modules by title

            $tags = explode(',',$query);
            $videos = Video::all()->keyBy('id');

            foreach ($tags as $tag_name)
            {
                $collection = $videos;

                $tag = Tag::where('tag',$tag_name)->first();
                if($tag != null)
                    $intersect = $collection->intersect($tag->videos->keyBy('id'));
                else
                    $intersect = $collection->intersect([]);
                $videos = $intersect;

            }
            $ids = $videos->keyBy('id')->keys();
            $videos = Video::whereIn('id',$ids)->with([
                    //'comments',
                    //'comments.author',
                    //'annotations',
                    //'annotations.author',
                    'author',
                    'participants',
                    'tags']
            )->where('hidden',0)->orderBy('updated_at', $sort);

        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }

    /**
     * @deprecated
     * @param $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return mixed
     */
    public function videosForUserParticipatingAndSharedWith_Raw($id, $take = 10, $sort = 'desc', $query = '') {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
            'comments',
            'comments.author',
            'annotations',
            'annotations.author',
            'author',
            'participants',
            'tags'
        ])->where('hidden',0)->participating($user->id)->orderBy('created_at', $sort);

        // Fetch videos that have been shared with this user
        $sharedVideosIds = UserShareObject::where('object_type', Video::class)
            ->whereHas('userShare', function($q) use ($id) {
                $q->where('recipient_id', $id);
            })
            ->get()
            ->pluck('object_id');

        if (count($sharedVideosIds)) {
            $videos->orWhereIn('id', $sharedVideosIds);
        }

        // Exclude deleted videos (if any)
        if (count($this->deletedVideoIds)) {
            $videos->whereNotIn('id', $this->deletedVideoIds);
        }

        return $videos->paginate($take);
    }

    /**
     * Get the latest videos for a user -- used when searching by title
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUser_TitleSearch($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
                'comments',
                'comments.author',
                'annotations',
                'annotations.author',
                'author',
                'participants',
                'tags']
        )->where('hidden',0)->orderBy('updated_at', $sort);

        // If a search query is provided then find a video by title or author
        if ($query) {
            $videos->searchTitle($query);
        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }

    /**
     * Get the latest videos for a user -- used when searching by author
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUser_AuthorSearch($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
                'comments',
                'comments.author',
                'annotations',
                'annotations.author',
                'author',
                'participants',
                'tags']
        )->where('hidden',0)->orderBy('updated_at', $sort);

        // If a search query is provided then find a video by title or author
        if ($query) {
            $videos->searchAuthor($query);
        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }



    /**
     * Get the latest videos for a user by tag
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserByTagAndDate($id, $take = 10, $sort = 'desc', $query = '', $year = '', $month = '', $day = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
                'comments',
                'comments.author',
                'annotations',
                'annotations.author',
                'author',
                'participants',
                'tags']
        )->orderBy('updated_at', $sort);

        if ($query) {
            // If a search query is provided then find learning modules by title

            $tags = explode(',',$query);
            $videos = Video::all()->keyBy('id');

            foreach ($tags as $tag_name)
            {
                $collection = $videos;

                $tag = Tag::where('tag',$tag_name)->first();
                if($tag != null)
                    $intersect = $collection->intersect($tag->videos->keyBy('id'));
                else
                    $intersect = $collection->intersect([]);
                $videos = $intersect;

            }
            $ids = $videos->keyBy('id')->keys();
            $videos = Video::whereIn('id',$ids)->with([
                    'comments',
                    'comments.author',
                    'annotations',
                    'annotations.author',
                    'author',
                    'participants',
                    'tags']
            )->where('hidden',0)->orderBy('updated_at', $sort);
        }

        if ($year) {
            $videos->where(DB::raw('YEAR(created_at)'), '=', $year);
        }

        if ($month) {
            $videos->where(DB::raw('MONTH(created_at)'), '=', $month);
        }

        if ($day) {
            $videos->where(DB::raw('DAY(created_at)'), '=', $day);
        }

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }

    /**
     * Get the latest videos for a user by author
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosForUserByAuthor($id, $take = 10, $sort = 'desc', $query = '', $authorId)
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's videos
        $videos = Video::with([
                'comments',
                'comments.author',
                'annotations',
                'annotations.author',
                'author',
                'participants',
                'tags']
        )
            ->where('hidden',0)
            ->where('author_id', $authorId)
            ->orderBy('updated_at', $sort);

        // If the user isn't a project admin or super admin then scope the videos
        // to only include videos they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $videos->authoredOrParticipatingExemplar($user->id);
        }

        return $videos->paginate($take);
    }

    /**
     * Store a new document on this video
     *
     * @param Video $video
     * @param UploadedFile $file
     * @param array $properties
     * @return null
     */
    public function document(Video $video, UploadedFile $file, $properties)
    {
        // Create a new document
        $document = new Document;
        $document->extension = $file->getClientOriginalExtension();
        $document->author_id = \Auth::id();
        $document->title = array_get($properties, 'title', $file->getClientOriginalName());
        $document->description = array_get($properties, 'description');

        // Create a new obfuscated filename
        $filename = str_random(16) . '.' . $document->extension;

        // Move the file to a more sensible location
        $file->move(public_path('uploads'), $filename);

        // Store the new path on the document
        $document->path = '/uploads/' . $filename;

        // Attach the new document to the video
        return $video->documents()->save($document);
    }

    /**
     * Get the videos with approval request
     *
     * @deprecated
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function videosWaitingForApprove($id, $take = 10, $sort = 'desc', $query = '')
    {
        $exemplars = Exemplar::where('approved',0)->where('exemplarable_type',Video::class)->orderBy('updated_at', $sort);

        return $exemplars->paginate($take);
    }
}
