<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\ResourceRepository;
use App\Resource;
use App\ResourceCategory;
use App\ResourceType;

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
        $resources = with(new Resource)->all();
        $resource_types = with(new ResourceType)
            ->orderBy('category')
            ->get();

        $resourceCategories = ResourceCategory::get();

        return view('resources.dashboard', [
            'page' => 'resources',
            'title' => 'Resources',
            'resources' => $resources,
            'resource_types' => $resource_types,
            'resourceCategories' => $resourceCategories
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
     * Destroys a resource and return to the list of resources of the same category and type
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param string category
     * @param string type
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $category, $type, $id)
    {
        $resource = Resource::findOrFail($id);

        if ($auth->user()->cannot('destroy', $resource)) {
            return abort(400, 'You do not have permission to delete this resource');
        }
        $resource->documents()->delete();
        $resource->documents()->detach();
        $resource->resource_types()->detach();
        $resource->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'resource');
        $request->session()->flash('flash.message', 'The Resource has been successfully deleted!');

        return redirect(url("resources/$category/$type"));
    }


    /**
     * Updates a resource
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $category, $type, $id)
    {
        $resource = Resource::findOrFail($id);
        if ($auth->user()->cannot('update', $resource)) {
            return abort(400, 'You do not have permission to edit this lesson plan');
        }
        $resource->update($request->only('title', 'description','remote_url'));

        $resource->save();

        // If a document was attached update it in the DB
        if($request->hasFile('document'))
            with(new ResourceRepository())->document(
                $resource,
                $request->file('document'),
                $request->only('title', 'description')
            );


        // Update the resource_types related with the resource
        $resource->resource_types()->detach();

        $resource_types = $request->get('resources_types');
        foreach ($resource_types as $resource_type_id)
        {
            $resource_type = ResourceType::find($resource_type_id);
            $resource->resource_types()->save($resource_type);
        }
        
        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'id');
        $request->session()->flash('flash.message', 'Your Resource has been successfully updated!');

        // Send the user back to the page they were on
        $resource_type = $resource->resource_types->where('category', $category)->where('type', $type)->first();

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
        return redirect(url("resources/$category_url/$type/$resource->id"));

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
        $categoryId = $request->has('category_id') ? $request->get('category_id') : '0';

        // Check if we need to create a new category
        if ($categoryId == 'new') {
            // Create new category
            $newCategory = new ResourceCategory;
            $newCategory->name = $request->get('new_category_name');

            // Save new category to the DB
            $newCategory->save();

            // Add new category ID to the post data
            $categoryId = $newCategory->id;
        }

        // Create a new learning module
        $resource = Resource::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'author_id' => $auth->id(),
            'remote_url' => $request->get('remote_url'),
            'resource_category_id' => $categoryId,
            'resource_type_id' => $request->get('resource_type_id')
        ]);

        // Save document related with the resource
        if($request->hasFile('document')) {
            with(new ResourceRepository())
                ->document(
                    $resource, $request->file('document'),
                    $request->only('title', 'description')
                );
        }

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'resources');
        $request->session()->flash('flash.message', 'Your Resource has successfully been created.');

        return redirect()->route('resources', [
            'subdomain' => $subdomain
        ]);
    }

}
