<?php

namespace App\Repositories;

use App\Document;
use App\ResourceType;
use Illuminate\Contracts\Auth\Guard;
use App\Resource;
use App\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\UserShareObject;

class ResourceRepository
{

    public function all($take = 10, $sort = 'desc', $query = '', $category, $type)
    {
        $resource_type = ResourceType::where(['type'=>$type,'category'=>$category])->first();

        $ids= [];
        foreach($resource_type->resources as $resource)
        {
            $ids[]=$resource->id;
        }

        $resources = Resource::whereIn('id',$ids)->orderBy('updated_at', $sort);

        // If a search query is provided then find learning modules by title or author
        if ($query) {
            $resources->searchTitle($query);
        }

        return $resources->paginate($take);
    }

    /**
     * Get the latest resources for a user
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function resourcesForUser($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's resources
        $resources = Resource::with([
            'author',
            'resource_types'
        ])->where('is_private', '0')
            ->orderBy('updated_at', $sort);
        
        // If a search query is provided then find a video by title or author
        if ($query) {
            $resources->searchTitle($query);
        }

        return $resources->paginate($take);
    }

    /**
     * Get the latest resources for a user
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function resourcesForUserSearch($id, $take = 100, $sort = 'desc', $tags = [], $year = '', $month = '', $day = '', $author = '', $title = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's resources
        $resources = Resource::with([
            'author',
            'resource_types'
        ]);

        if ($tags) {
            // If a search query is provided then find learning modules by title

            //$tags = explode(',', $tags);
            $resources = Resource::all()->keyBy('id');
            $collection = $resources;

            foreach ($tags as $tag_id) {
                $tag = Tag::where('id', $tag_id)->first();

                if ($tag != null) {
                    $intersect = $collection->intersect($tag->resources->keyBy('id'));
                } else {
                    $intersect = $collection->intersect([]);
                }

                $resources = $intersect;
            }

            $ids = $resources->keyBy('id')->keys();
            $resources = Resource::whereIn('id', $ids)->with([
                    'author',
                    'resource_types'
            ]);
        }

        if ($year) {
            $resources->where(DB::raw('YEAR(created_at)'), '=', $year);
        }

        if ($month) {
            $resources->where(DB::raw('MONTH(created_at)'), '=', $month);
        }

        if ($day) {
            $resources->where(DB::raw('DAY(created_at)'), '=', $day);
        }

        if ($author) {
            /*$videos->where(function($q) use ($author) {
                $q->whereHas('author', function ($q) use ($author) {
                    $q->where('name', 'LIKE', "%$author%");
                    $q->orWhere('nickname', 'LIKE', "%$author%");
                });
            });*/
            $resources->whereIn('author_id', $author);
        }

        if ($title) {
            $resources->where(function($q) use ($title) {
                $q->where(DB::raw('title'), 'LIKE', '%'. $title .'%')
                    ->orWhere(DB::raw('description'), 'LIKE', '%'. $title .'%');
            });
        }

        $resources->orderBy('created_at', $sort);
        
        $results = $resources->get();

        // @TODO: HOW DOES is_private PLAY A ROLE HERE?
        $searchResults = [];

        foreach ($results as $result) {
            if ($result->is_private == '1') {
                if ($result->author_id == $id) {
                    $searchResults[] = $result;
                }
            } else {
                $searchResults[] = $result;
            }
        }

        return $searchResults;

        //return $resources->paginate($take);
    }

    /**
     * Get the latest resources by type
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function resourcesForType($category, $type, $take = 10, $sort = 'desc', $query = '')
    {

        // Setup the query for retrieving a user's resources
        $resources = Resource::with([
            'author',
            'resource_types'
        ])->orderBy('updated_at', $sort);

        // If a search query is provided then find a video by title or author
        if ($query) {
            $resources->searchTitleOrAuthor($query);
        }

        return $resources->paginate($take);
    }
    /**
     * Store or replace a new document on this resource
     *
     * @param Resource $resource
     * @param UploadedFile $file
     * @param array $properties
     */
    public function document(Resource $resource, UploadedFile $file, $properties)
    {
        // Create a new document if it doesn't exists
        $document = $resource->documents()->first();
        if($document == null)
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

        // Attach the new document to the resource
        $resource->documents()->detach();
        return $resource->documents()->save($document);
    }

    public function resourcesForUserSharedWith($id, $take = 50, $sort = 'desc', $query = '') {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's resources
        $resources = Resource::with([
            'author',
            'resource_types'
        ]);

        // Fetch resources that have been shared with this user
        $sharedResourceIds = UserShareObject::where('object_type', Resource::class)
            ->whereHas('userShare', function($q) use ($id) {
                $q->where('recipient_id', $id);
            })
            ->get()
            ->pluck('object_id');

        if (count($sharedResourceIds)) {
            $resources->whereIn('id', $sharedResourceIds);

            return $resources->paginate();
        } else {
            return collect([]);
        }
    }
}
