<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ResourceRepository;
use App\Resource;
use Illuminate\Http\Request;
use App\Repositories\VideoRepository;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;

class ResourcesController extends Controller
{
    /**
     * Lists out resources and allows the user to search
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index($subdomain, Guard $auth, Request $request)
    {
        $resources = with(new ResourceRepository())->resourcesForUser(
            $auth->id(),
            $request->get('take', 10),
            $request->get('sort', 'desc'),
            $request->get('q')
        );
        $resources->getCollection()->map(function($resource)
        {
            //$resource_type = $resource->resource_types->first();
            //$resource->hide_author = 1;
            //if($resource_type!=null)
            $resource->url = url("resource/". $resource->id);
        });

        return ['results' => $resources->items()];
    }

    /**
     * List out the resource_types for the resource
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function resource_types($subdomain, Guard $auth, Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        return $resource->resource_types;
    }
}
