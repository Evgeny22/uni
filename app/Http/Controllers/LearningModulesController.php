<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\LearningModuleRepository;
use App\LearningModule;

class LearningModulesController extends Controller
{
    /**
     * Shows a list of learning modules
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request)
    {
        $learningModules = with(new LearningModuleRepository)->all(10,$request->get('sort'));

        return view('learning-modules.index', [
            'page' => 'learning-modules',
            'title' => 'Learning Modules',
            'learningModules' => $learningModules
        ]);
    }

    /**
     * Updates a learning module
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request, $id)
    {
        $learningModule = LearningModule::findOrFail($id);
        if ($auth->user()->cannot('update', $learningModule)) {
            return abort(400, 'You do not have permission to edit this learning module');
        }

        // Filter out any empty or null values being passed back here
        $learningModule->fill(array_filter($request->only(
            'title',
            'description',
            'zoom_url',
            'wistia_id',
            'wistia_hashed_id',
            'wistia_duration',
            'wistia_thumbnail'
        )))->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'lm');
        $request->session()->flash('flash.message', 'Your Learning Module has been successfully updated!');

        // Send the user back to the page they were on
        return redirect()->route('learning-modules.show', [
            'subdomain' => $subdomain,
            'id' => $learningModule->id
        ]);
    }

    /**
     * Shows one learning module by id
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, $id)
    {
        $learningModule = LearningModule::findOrFail($id);
        return view('learning-modules.show', [
            'page' => 'learning-module',
            'title' => 'Learning Modules',
            'learningModule' => $learningModule
        ]);
    }

    /**
     * Create a new learning module
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new learning module
        if ($auth->user()->cannot('create', new LearningModule)) {
            return abort(400, 'You do not have permission to create a new Learning Module');
        }

        // Create a new learning module
        $learningModule = LearningModule::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'author_id' => $auth->id(),
            'zoom_url' => $request->get('zoom_url')
        ]);

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'lm');
        $request->session()->flash('flash.message', 'Your Learning Module has successfully been created.');

        // Redirect the user to the learning module show page
        return redirect()->route('learning-modules.show', [
            'subdomain' => $subdomain,
            'id' => $learningModule->id
        ]);
    }

    /**
     * Destroys a learning module
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request, $id)
    {
        $learningModule = LearningModule::findOrFail($id);

        if ($auth->user()->cannot('destroy', $learningModule)) {
            return abort(400, 'You do not have permission to delete this learning module');
        }

        $learningModule->delete();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'lm');
        $request->session()->flash('flash.message', 'The Learning Module has been successfully deleted!');

        return redirect()->route('learning-modules.index', [
            'subdomain' => $subdomain,
        ]);
    }
}
