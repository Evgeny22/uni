<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests;

use App\Cycle;
use App\CycleStep;
use App\CycleProgress;

class CyclesController extends Controller
{
    /**
     * Shows a list of cycles
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request)
    {
        $cycles = Cycle::get();

        return view('cycles.index', [
            'page' => 'cycles',
            'title' => 'Cycles',
            'cycles' => $cycles
        ]);
    }

    /**
     * Shows one cycle by id
     *
     * @param string $subdomain
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param int $id
     * @return Illuminate\View\View
     */
    public function show($subdomain, Guard $auth, $id)
    {
        $cycle = Cycle::findOrFail($id);

        return view('cycles.show', [
            'page' => 'cycles',
            'title' => 'Cycle',
            'cycle' => $cycle
        ]);
    }

    /**
     * Create a new video
     *
     * @param string $subdomain
     * @param Guard $auth
     * @param Request $request
     * @return View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new cycle
        /*if ($auth->user()->cannot('create', new Cycle)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new cycle
        $cycle = Cycle::create([
            'title' => $request->get('column_name'),
            'color' => $request->get('column_color'),
            'author_id' => $auth->user()->id
        ]);

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your cycle has been created!');

        // Redirect the user to the video show page
        return redirect()->route('video-center.show', [
            'subdomain' => $subdomain,
            'id' => $request->get('video_id')
        ]);
    }

    public function storeStep($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new cycle
        /*if ($auth->user()->cannot('create', new Cycle)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new cycle step
        $cycleStep = CycleStep::create([
            'cycle_id' => $request->get('cycle_id'),
            'object_id' => $request->get('object_id'),
            'object_type' => $request->get('object_type'),
            'type' => $request->get('type')
        ]);

        return response(null, 200);
    }
}
