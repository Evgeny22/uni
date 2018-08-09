<?php

namespace App\Http\Controllers;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\ResourceRepository;
use App\Repositories\UserRepository;
use App\Resource;
use App\ResourceCategory;
use App\ResourceType;
use Illuminate\Support\Collection;
use App\Tag;
use App\UserSaveObject;
use App\Comment;

class ResourcesController extends Controller
{

    /**
     * Shows a list of resources
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request)
    {
        // Public resources
        $resources = Resource::where('is_private', '0')->orderBy('created_at', 'desc')->get();
        $resource_types = with(new ResourceType)
            ->orderBy('category')
            ->get();

        // Private documents
        $privateDocuments = Resource::where('author_id', $auth->user()->id)
                            ->where('is_private', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();

        //$resourceCategories = ResourceCategory::all();

        // Tags
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

        // Get saved resources
        $savedResources = UserSaveObject::where('object_type', Resource::class)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->get();

        $savedResourcesById = [];
        if (count($savedResources)) {
            foreach($savedResources as $savedResource) {
                $savedResourcesById[$savedResource->object_id] = $savedResource;
            }
        }

        //dd($savedResourcesById);

        $savedResources = Resource::whereIn('id', $savedResources->pluck('object_id'))
            ->get();

        $savedResources = $savedResources->sortByDesc(function($savedResource) use($savedResourcesById) {
            return $savedResourcesById[$savedResource->id]['created_at'];
        });

        // Get shared with me resources
        $sharedWithMeResources = with(new ResourceRepository)->resourcesForUserSharedWith(
            $auth->id(),
            $request->get('take', 50),
            $request->get('sort')
        );

        return view('resources.dashboard', [
            'page' => 'resources',
            'title' => 'Resources',
            'resources' => $resources,
            'privateDocuments' => $privateDocuments,
            'savedResources' => $savedResources,
            'sharedWithMeResources' => $sharedWithMeResources,
            'resource_types' => $resource_types,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas
        ]);
    }

    /**
     * Searches for resources with the given criteria
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     */
    public function search($subdomain, Guard $auth, Request $request) {
        $resources = with(new ResourceRepository)->resourcesForUserSearch(
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

        $resource_types = with(new ResourceType)
            ->orderBy('category')
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

        return view('resources.dashboard', [
            'page' => 'resources',
            'title' => 'Resources',
            'resources' => $resources,
            'prefilled' => $prefilled,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas,
            'resource_types' => $resource_types
        ]);
    }

    /**
     * Shows resources by category and type
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param string $category
     * @param string $type
     * @return Illuminate\View\View
     */
    public function resourcesByCategory($subdomain, Guard $auth, Request $request, $category, $type)
    {
        $this->category=$category;
        $this->type=$type;
        
        $resource_types = with(new ResourceType)->orderBy('category')->get();

        $resources = with(new ResourceRepository)->all(10,$request->get('sort'),'', str_replace("-"," ",$category), $type);

        $resources->map(function($resource)
        {
            $resource->url = url("resources/$this->category/$this->type/".$resource->id);
        });

        return view('resources.index', [
            'page' => 'resources_category',
            'title' => 'Resources',
            'category' => str_replace("-"," ",$category),
            'type' => $this->type,
            'resources' => $resources,
            'resource_types' => $resource_types
        ]);
    }

    /**
     * Shows one resource by id
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param string $category
     * @param string $type
     * @param int $id
     * @return Illuminate\View\View
     */
    public function showByCategory($subdomain, Guard $auth, $category, $type, $id )
    {
        $resource = Resource::findOrFail($id);
        $resource->url = url("resources/$category/$type/".$id);

        $resource_types = with(new ResourceType)->orderBy('category')->get();

        return view('resources.show', [
            'page' => 'resources',
            'title' => 'Resources',
            'category' => str_replace("-"," ",$category),
            'type' => $type,
            'resource' => $resource,
            'resource_types' => $resource_types
        ]);
    }

    /**
     * Shows one resource by id
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param string $category
     * @param string $type
     * @param int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, $id )
    {
        $resource = Resource::with('comments')->findOrFail($id);
        //$resource->url = url("resources/$category/$type/".$id);

        // Fetch tags associated to video
        $resourceTags = collect($resource->tags)->pluck('tag')->toArray();

        $resource_types = with(new ResourceType)->orderBy('category')->get();

        // Tags
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

        // Saved
        $isSaved = false;

        $saved = UserSaveObject::where('object_type', 'App\\Resource')
            ->where('object_id', $id)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->first();

        if (!empty($saved->object_id)) {
            $isSaved = true;
        }

        return view('resources.show', [
            'page' => 'resources',
            'title' => 'Resources',
            'category' => '',//str_replace("-"," ",$category),
            'type' => '',//'$type,
            'resource' => $resource,
            'isSaved' => $isSaved,
            'resourceTags' => $resourceTags,
            'resource_types' => $resource_types,
            'crosscuttingConcepts' => $crosscuttingConcepts,
            'practices' => $practices,
            'coreIdeas' => $coreIdeas
        ]);
    }


     /**
     * Destroys a resource and return to the list of resources of the same category and type
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param string category
     * @param string type
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        /*if ($auth->user()->cannot('destroy', $resource)) {
            return abort(400, 'You do not have permission to delete this resource');
        }*/

        $resource->documents()->delete();
        $resource->documents()->detach();
        $resource->resource_types()->detach();
        $resource->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'resource');
        $request->session()->flash('flash.message', 'The Resource has been successfully deleted!');

        return redirect()->route('resources', [
            'subdomain' => $subdomain
        ]);
    }


    /**
     * Updates a resource
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        if ($auth->user()->cannot('update', $resource)) {
            return abort(400, 'You do not have permission to edit this resource');
        }

        $resource->update($request->only('title', 'description','remote_url', 'resource_type_id'));

        $resource->save();

        // If a document was attached update it in the DB
        if($request->hasFile('document')) {
            with(new ResourceRepository())->document(
                $resource,
                $request->file('document'),
                $request->only('title', 'description')
            );
        }

        // Update the resource_types related with the resource
        /*$resource->resource_types()->detach();

        $resource_types = $request->get('resources_types');
        foreach ($resource_types as $resource_type_id)
        {
            $resource_type = ResourceType::find($resource_type_id);
            $resource->resource_types()->save($resource_type);
        }*/

        // If tags were selected for this video then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the video
            $resource->tags()->sync($tags);
        } else {
            $resource->tags()->detach();
        }
        
        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'Your Resource has been successfully updated!');

        // Send the user back to the page they were on
        /*$resource_type = $resource->resource_types->where('category', $category)->where('type', $type)->first();

        if($resource_type == null)
        {
            $resource_type = $resource->resource_types->first();
            if($resource_type != null)
            {
                $category = $resource_type->category;
                $type = $resource_type->type;
            }

        }
        // Redirect the user to the learning module show page
        $category_url = str_replace(" ","-",$category);
        return redirect(url("resources/$category_url/$type/$resource->id"));*/

        return redirect()->route('resources.show', [
            'subdomain' => $subdomain,
            'id' => $resource->id
        ]);

    }

    /**
     * Create a new resource
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if category ID was passed
        $categoryId = '0';

        // Create a new learning module
        $resource = Resource::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'author_id' => $auth->id(),
            'remote_url' => $request->get('remote_url'),
            'resource_category_id' => $categoryId,
            'resource_type_id' => $request->get('resource_type_id'),
            'is_private' => $request->get('is_private')
        ]);

        // Save document related with the resource
        if($request->hasFile('document')) {
            with(new ResourceRepository())
                ->document(
                    $resource, $request->file('document'),
                    $request->only('title', 'description')
                );
        }

        // If tags were selected for this video then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the video
            $resource->tags()->sync($tags);
        }

        //$documentType = $request->get('is_private') == 1 ? 'Private Document' : 'Public Resource';
        $documentType = 'document';

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'resources');
        $request->session()->flash('flash.message', 'Your '. $documentType .' has successfully been created.');

        return redirect()->route('resources.show', [
            'subdomain' => $subdomain,
            'id' => $resource->id
        ]);
    }

    public function makeResource($subdomain, Guard $auth, Request $request, $id) {
        $resource = Resource::findOrFail($id);
        $resource->is_private = '0';
        $resource->save();

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your document has been successfully made into a resource!');

        return redirect()->route('resources.show', [
            'subdomain' => $subdomain,
            'id' => $resource->id
        ]);
    }

    public function makePublic($subdomain, Guard $auth, Request $request, $id) {
        $resource = Resource::findOrFail($id);
        $resource->is_private = '0';
        $resource->save();

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your document has been successfully made public!');

        return redirect()->route('resources.show', [
            'subdomain' => $subdomain,
            'id' => $resource->id
        ]);
    }

    /**
     * Store a new comment for a video
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function storeComment($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the resource the user is commenting on
        $resource = Resource::findOrFail($id);

        // If the user doesn't have permission to comment on this resource then
        // throw a 403 error
        // @TODO: Implement permissions
        /*if ($auth->user()->cannot('comment', $resource)) {
            abort(403, 'You do not have permission to comment on this resource');
        }*/

        $parentId = $request->get('parent_id');

        $saved = $resource->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        return $saved ? response(['comment_id' => $saved->id], 200) : abort(400);
    }

}
