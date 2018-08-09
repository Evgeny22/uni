<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Document;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LessonPlanRepository;
use App\Repositories\VideoRepository;

class DocumentsController extends Controller
{
    /**
     * Stoers a new document on a lesson plan
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View;
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $document = Document::findOrFail($id);

        if ($auth->user()->cannot('destroy', $document)) {
            return abort(400, 'You do not have permission to delete this document');
        }

        $document->delete();

        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'default');
        $request->session()->flash('flash.message', 'The document has been removed.');

        return redirect()->back();

    }

}
