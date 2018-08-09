<?php

namespace App\Http\Controllers\LearningModules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentStoreRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LearningModuleRepository;
use App\LearningModule;

class DocumentsController extends Controller
{
    /**
     * Destroys a document that's attached to a video
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param App\Http\Requests\DocumentStoreRequest $request
     * @param int $id
     * @return Illuminate\Http\RedirectResponse;
     */
    public function store($subdomain, Guard $auth, DocumentStoreRequest $request, $id)
    {
        $learningModule = LearningModule::findOrFail($id);

        if ($auth->user()->cannot('document', $learningModule)) {
            return abort(400, 'You do not have permission to attach a document to this learning module');
        }

        // Store a new document for this video
        with(new LearningModuleRepository)->document(
            $learningModule,
            $request->file('document'),
            $request->only('title', 'description')
        );

        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'lm');
        $request->session()->flash('flash.message', 'The document has been added to this Learning Module.');

        return redirect()->back();
    }

}
