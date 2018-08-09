<?php

namespace App\Http\Controllers\Api;

use App\Annotation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LessonPlanRepository;
use App\Video;

class AnnotationsController extends Controller
{
    public function showAnnotations($subdomain, Guard $auth, Request $request, $videoId) {
        // Fetch video
        $video = Video::findOrFail($videoId);

        $annotationsModel = $video->annotations()->where('author_id', $auth->user()->id)->/*with('author')->*/get();

        return ['annotations' => $annotationsModel];
    }

    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $annotation = Annotation::findOrFail($id);

        $annotation->fill($request->only('content'));

        $annotation->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your annotation has been successfully updated!');

        // Send the user back to the page they were on
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id')
        ]);
    }

    /**
     * Delete an annotation
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param App\Annotation $annotation
     * @return Illuminate\View\View;
     */
    public function destroy($subdomain, Guard $auth, $annotationId)
    {
        /*if ($user->user()->cannot('destroy', $annotation)) {
            return abort(400, 'You do not have permission to delete this annotation');
        }*/

        $annotation = Annotation::where('id', $annotationId);

        $annotation->delete();

        return response(200);
    }
}
