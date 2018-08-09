<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use Auth;
use stdClass;

class TagsController extends Controller
{
    /**
     * Lists out the possible tags for a video
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View;
     */
    public function index($subdomain, Request $request)
    {
        $output = [];

        // Get the possible tags
        $tags  = Tag::where('tag','LIKE','%'.$request->get('q').'%')->get();
        

        foreach ($tags as $tag) {
            $obj = new stdClass;
            $obj->id = $tag->id;
            $obj->text = $tag->tag;
            $output[] = $obj;
        }
        
        return ['results' => collect($output)->values()];
    }
}
