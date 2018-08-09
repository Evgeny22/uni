<?php

namespace App\Http\Controllers;

use App\ProgressBarStepProgress;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

use App\Http\Requests;
use App\User;
use App\ProgressBar;
use App\ProgressBarStep;
use App\ProgressBarStepType;
use App\Tag;
use App\UserShareObject;
use App\UserSaveObject;
use App\Comment;

use Illuminate\Support\Facades\DB;

class ProgressBarsController extends Controller
{
    public function index($subdomain, Guard $auth, Request $request) {
        $allVisibleProgressBars = collect([]);

        if ($auth->user()->isEither(['admin', 'super_admin'])) {
            // Fetch progress bars
            //$progressBars = ProgressBar::all()->orderBy('created_at', 'desc');
            $progressBars = ProgressBar::with([
                'author',
                'tags',
                'steps',
                'steps.usersProgress',
                'steps.type',
                'steps.participant',
                'participants',
                'comments'
            ])->orderBy('created_at', 'desc')->get();
        } else {
            $progressBars = ProgressBar::with([
                'author',
                'tags',
                'steps',
                'steps.usersProgress',
                'steps.type',
                'steps.participant',
                'participants',
                'comments'
            ])->where('author_id', $auth->user()->id)->orderBy('created_at', 'desc')->get();
        }

        if ($progressBars->count() > 0) {
            foreach ($progressBars as $pb) {
                $allVisibleProgressBars->push($pb);
            }
        }

        // Fetch progress bars that this user is a participant of the progress bar
        $progressBarsParticipant = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'steps.participant',
            'participants',
            'comments'
        ])->participating($auth->id())->get();

        if ($progressBarsParticipant->count() > 0) {
            foreach ($progressBarsParticipant as $pPB) {
                if (!$allVisibleProgressBars->contains('id', $pPB->id)) {
                    $allVisibleProgressBars->push($pPB);
                }
            }
        }

        // Fetch progress bars that this user is a participant of a task
        $progressBarsTaskParticipant = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'steps.participant',
            'participants',
            'comments'
        ])->isParticipant($auth->id())->get();

        if ($progressBarsTaskParticipant->count() > 0) {
            foreach ($progressBarsTaskParticipant as $tPB) {
                if (!$allVisibleProgressBars->contains('id', $tPB->id)) {
                    $allVisibleProgressBars->push($tPB);
                }
            }
        }

        //$progressBarsParticipant->push($progressBarsTaskParticipant);

        ////dd($allVisibleProgressBars);

        // Fetch progress bars that have been shared with this user
        $progressBarsSharedIds = UserShareObject::where('object_type', 'App\\ProgressBar')
            ->whereHas('userShare', function($q) use ($auth) {
                $q->where('recipient_id', $auth->user()->id);
            })
            ->get()
            ->pluck('object_id');

        if (count($progressBarsSharedIds) > 0) {
            // Fetch progress bars with ID in the sharedIds array
            $progressBarsShared = ProgressBar::with([
                'author',
                'tags',
                'steps',
                'steps.usersProgress',
                'steps.type',
                'steps.participant',
                'participants',
                'comments'
            ])->whereIn('id', $progressBarsSharedIds)->get();

            foreach ($progressBarsShared as $sPB) {
                if (!$allVisibleProgressBars->contains('id', $sPB->id)) {
                    $allVisibleProgressBars->push($sPB);
                }
            }

            //$progressBarsParticipant->merge($progressBarsShared);
            //$progressBarsShared->merge($progressBarsParticipant);
        }

        // Order progress bars
        if ($allVisibleProgressBars->count() > 0) {
            $allVisibleProgressBars = $allVisibleProgressBars->sortByDesc(function ($progressBar) {
                return $progressBar->created_at;
            });
        }

        // Fetch progress bars with templates
        $progressBarTemplates = ProgressBar::where('is_template', '1')->get();

        /*$savedProgressBarIds = UserSaveObject::where('object_type', 'App\\ProgressBar')
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->get()
            ->pluck('object_id');*/

        //$progressBarsSaved = ProgressBar::whereIn('id', $savedProgressBarIds)->get();

        // Fetch progress bar types
        $progressBarStepTypes = ProgressBarStepType::all();

        // Create a collection of all progress bars
        ////$allVisibleProgressBars = collect($progressBars, $progressBarsShared);
        //dump($allVisibleProgressBars);
        $progressBarsCompleted = collect([]);

        // Loop through each visible progress bar
        foreach ($allVisibleProgressBars as $visibleProgressBar) {
            if ($visibleProgressBar->steps->count()) {
                $numSteps = 0;
                $numCompleted = 0;

                foreach ($visibleProgressBar->steps as $i => $step) {
                    $numSteps++;

                    $progress = $step->usersProgress;

                    if ($progress->count() > 0) {
                        foreach ($progress as $data) {
                            if ($data['completed'] == '1') {
                                //$pbOverallProgress[] = '1';
                                $numCompleted++;
                            }
                        }
                    }
                }

                if ($numSteps != 0 && $numCompleted != 0) {
                    if ($numSteps == $numCompleted) {
                        $progressBarsCompleted->push($visibleProgressBar);
                    }
                }
            }
        }

        // Create array of task ID => [user ID => completed status], for each step/task
        $pbStepProgress = [];
        $pbStepsCompleted = [];
        $pbStepsCompletedByPBId = [];
        $pbStepsProgressByPBId = [];

        if ($allVisibleProgressBars->count() > 0) {
            foreach ($allVisibleProgressBars as $progressBar) {
                if ($progressBar->steps->count() > 0) {
                    foreach ($progressBar->steps as $i => $step) {
                        $progress = $step->usersProgress;

                        if ($progress->count() > 0) {
                            foreach ($progress as $data) {
                                if ($data['completed'] == '1') {
                                    $pbStepProgress[$step['id']][$data['participant_id']] = $data['completed'];
                                    $pbStepsCompleted[] = $step['id'];
                                    $pbStepsCompletedByPBId[$progressBar->id][] = $step['id'];
                                    $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '1';
                                } else {
                                    $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '0';
                                }
                            }
                        } else {
                            $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '0';
                        }
                    }
                } else {
                    $pbStepsProgressByPBId[$progressBar->id][] = '0';
                }
            }
        }

        // Filter out duplicate set ids.
        foreach($pbStepsCompletedByPBId as $id => $progressBar) {
          $pbStepsCompletedByPBId[$id] = array_unique($progressBar);
          debug($id);
          debug(array_unique($progressBar));
        }
        debug($pbStepsCompletedByPBId);
        return view('progress-bars/index', [
            'page' => 'progress-bars',
            'title' => 'Progress Bars',
            'progressBars' => $allVisibleProgressBars,//$progressBars,
            'progressBarsShared' => $progressBarsParticipant,//$progressBarsShared,
            //'progressBarsSaved' => $progressBarsSaved,
            'progressBarTemplates' => $progressBarTemplates,
            'progressBarStepTypes' => $progressBarStepTypes,
            'progressBarsCompleted' => $progressBarsCompleted,
            'pbStepProgress' => $pbStepProgress,
            'pbStepsCompleted' => $pbStepsCompleted,
            'pbStepsCompletedByPBId' => $pbStepsCompletedByPBId,
            'pbStepsProgressByPBId' => $pbStepsProgressByPBId
        ]);
    }

    public function show($subdomain, Guard $auth, Request $request, $id) {
        //========================================================================================
        // Delete any progress bar steps that have been added without info.
        //
        // This only happens if someone clicks on the icon to add a new task, then completely
        // abandons the page. Which, if the app is used properly, will never happen.
        //
        // This is the definition of an edge-case bug fix.
        //
        // This may cause problems, if for example the user is creating a progress bar, they add a
        // step, then mid-step they go to another progress bar /show/ page, the task will be
        // deleted.
        //
        // Enjoy.
        //========================================================================================

        // Search for progress bar tasks that are empty by this author
        $emptyProgressBarTasks = ProgressBarStep::where('author_id', $auth->id())
            ->where('name', '')
            ->where('desc', '')
            ->get();

        if (count($emptyProgressBarTasks)) {
            //dd($emptyProgressBarTasks);

            // Loop through each empty progress bar task
            foreach ($emptyProgressBarTasks as $emptyTask) {
                //dump(['Going to delete task ID' => $emptyTask->id]);

                // Delete the empty task
                $emptyTask->delete();
            }
        }

        // Fetch this progress bar
        $progressBar = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'participants',
            'comments'
        ])->findOrFail($id);

        $tags = $progressBar->tags;
        $tagArray = [];

        foreach ($tags as $tag) {
            $tagArray[] = [
                'id' => $tag['id'],
                'name' => $tag['tag']
            ];
        }

        $progressBar->tagArray = json_encode($tagArray);

        $progressBars = collect([$progressBar]);

        // Fetch progress bars with templates
        $progressBarTemplates = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'participants',
            'comments'
        ])->where('is_template', '1')->get();

        // Check if this user has saved this progress bar
        $isSaved = false;

        $saved = UserSaveObject::where('object_type', 'App\\ProgressBar')
            ->where('object_id', $id)
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->first();

        if (!empty($saved->object_id)) {
            $isSaved = true;
        }

        // Create array of task ID => [user ID => completed status], for each step/task
        $pbStepProgress = [];
        $pbStepsCompleted = [];
        $pbStepsCompletedByPBId = [];
        $pbStepsProgressByPBId = [];

        if ($progressBars->count() > 0) {
            foreach ($progressBar->steps as $i => $step) {
                $progress = $step->usersProgress;

                if ($progress->count() > 0) {
                    foreach ($progress as $data) {
                        if ($data['completed'] == '1') {
                            $pbStepProgress[$step['id']][$data['participant_id']] = $data['completed'];
                            $pbStepsCompleted[] = $step['id'];
                            $pbStepsCompletedByPBId[$progressBar->id][] = $step['id'];
                            $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '1';
                        } else {
                            $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '0';
                        }
                    }
                } else {
                    $pbStepsProgressByPBId[$progressBar->id][$step['id']] = '0';
                }
            }
        }

        // Create array of completed and not completed tasks
        $pbOverallProgress = [];

        if ($progressBars->count() > 0) {
            foreach ($progressBar->steps as $i => $step) {
                $progress = $step->usersProgress;

                if ($progress->count() > 0) {
                    foreach ($progress as $data) {
                        //$pbStepProgress[$step['id']][$data['participant_id']] = $data['completed'];

                        if ($data['completed'] == '1') {
                            $pbOverallProgress[] = '1';
                        } else {
                            $pbOverallProgress[] = '0';
                        }
                    }
                } else {
                    $pbOverallProgress[] = '0';
                }
            }
        }

        //dump($pbOverallProgress);

        // Create array of completed "order"'s
        $pbCompleteOrders = [];

        if ($progressBars->count() > 0) {
            foreach ($progressBar->steps as $i => $step) {
                $progress = $step->usersProgress;

                if ($progress->count() > 0) {
                    foreach ($progress as $data) {
                        //$pbStepProgress[$step['id']][$data['participant_id']] = $data['completed'];

                        if ($data['completed'] == '1') {
                            $pbCompleteOrders[] = $step->order;
                        }
                    }
                }
            }
        }

        $pbCompleteOrders = json_encode($pbCompleteOrders);

        // Fetch progress bar types
        $progressBarStepTypes = ProgressBarStepType::all();

        return view('progress-bars/show', [
            'page' => 'progress-bars',
            'title' => 'Progress Bars',
            'progressBar' => $progressBar,
            'progressBars' => $progressBars,
            'progressBarTemplates' => $progressBarTemplates,
            'pbStepProgress' => $pbStepProgress,
            'pbStepsCompleted' => $pbStepsCompleted,
            'pbOverallProgress' => $pbOverallProgress,
            'pbCompleteOrders' => $pbCompleteOrders,
            'pbStepsCompletedByPBId' => $pbStepsCompletedByPBId,
            'isSaved' => $isSaved,
            'progressBarStepTypes' => $progressBarStepTypes,
            'pbStepsProgressByPBId' => $pbStepsProgressByPBId
        ]);
    }

    public function search($subdomain, Guard $auth, Request $request) {
        //dd($request->get('title'));
        $progressBars = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'participants'
        ])->orderBy('updated_at', 'desc');

        if ($request->get('author')) {
            $author = $request->get('author');

            if (is_array($author)) {
                $progressBars->whereIn('author_id', $author);
            } else {
                $progressBars->where(function($q) use ($author) {
                    $q->whereHas('author', function ($q) use ($author) {
                        $q->where('name', 'LIKE', "%$author%");
                        $q->orWhere('nickname', 'LIKE', "%$author%");
                    });
                });
            }
        }

        if ($request->get('title')) {
            $progressBars->where('name', 'LIKE', "%". $request->get('title') ."%");
        }

        $prefilled = [];

        if ($request->has('search_tags') && is_array($request->get('search_tags'))) {
            // Fetch tags
            $prefilled['tags'] = Tag::whereIn('id', $request->get('search_tags'))->get();
        }

        if ($request->get('search_tags')) {
            //$tags = explode(',', $request->get('search_tags'));
            $progressBars = ProgressBar::with([
                'author',
                'tags',
                'steps',
                'steps.usersProgress',
                'steps.type',
                'participants'
            ])->get()->keyBy('id');

            foreach ($request->get('search_tags') as $tag_id) {
                $collection = $progressBars;

                $tag = Tag::where('id', $tag_id)->first();

                if ($tag != null) {
                    $intersect = $collection->intersect($tag->progressBars->keyBy('id'));
                } else {
                    $intersect = $collection->intersect([]);
                }

                $progressBars = $intersect;
            }

            $ids = $progressBars->keyBy('id')->keys();
            $progressBars = ProgressBar::with([
                'author',
                'tags',
                'steps',
                'steps.usersProgress',
                'steps.type',
                'participants'
            ])->whereIn('id', $ids)->orderBy('updated_at', 10);
        }

        if ($request->get('year')) {
            $progressBars->where(DB::raw('YEAR(created_at)'), '=', $request->get('year'));
        }

        if ($request->get('month')) {
            $progressBars->where(DB::raw('MONTH(created_at)'), '=', $request->get('month'));
        }

        if ($request->get('day')) {
            $progressBars->where(DB::raw('DAY(created_at)'), '=', $request->get('day'));
        }

        //--------------------------------
        // SHARED PROGRESS BARS
        //--------------------------------

        // Fetch progress bars that this user is a participant of
        $progressBarsShared = ProgressBar::with('participants')->participating($auth->id())->get();

        // Fetch progress bars with templates
        $progressBarTemplates = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'participants'
        ])->where('is_template', '1')->get();

        // Fetch saved progress bars
        $savedProgressBarIds = UserSaveObject::where('object_type', 'App\\ProgressBar')
            ->whereHas('userSave', function($q) use ($auth) {
                $q->where('author_id', $auth->user()->id);
            })
            ->get()
            ->pluck('object_id');

        $progressBarsSaved = ProgressBar::with([
            'author',
            'tags',
            'steps',
            'steps.usersProgress',
            'steps.type',
            'participants'
        ])->whereIn('id', $savedProgressBarIds)->get();

        // Build prefilled array
        $prefilled = [];

        if ($request->get('author') && is_array($request->get('author'))) {
            // Fetch author names
            $prefilled['author'] = with(new UserRepository)->getUsers($request->get('author'));
        }

        if ($request->get('search_tags') && is_array($request->get('search_tags'))) {
            // Fetch tags
            $prefilled['tags'] = Tag::whereIn('id', $request->get('search_tags'))->get();
        }

        // Fetch progress bar types
        $progressBarStepTypes = ProgressBarStepType::all();

        return view('progress-bars/index', [
            'page' => 'progress-bars',
            'title' => 'Progress Bars',
            'progressBars' => $progressBars->get(),
            'progressBarsShared' => $progressBarsShared,
            'progressBarTemplates' => $progressBarTemplates,
            'progressBarsSaved' => $progressBarsSaved,
            'progressBarStepTypes' => $progressBarStepTypes,
            'prefilled' => $prefilled
        ]);
    }

    /**
     * Create a new progress bar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function store($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video
        /*if ($auth->user()->cannot('create', new Video)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new progress bar
        $progressBar = ProgressBar::create([
            'author_id' => $auth->id(),
            'name' => $request->get('name')
        ]);

        // If participants were selected for this progress bar then add them here
        if ($participants = $request->input('participants')) {
            $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($participants));

            // Attach the user participants to the video
            $progressBar->participants()->sync($participantIds);
        }

        // If tags were selected for this progress bar then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the progress bar
            $progressBar->tags()->sync($tags);
        }

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your Progress Bar has been created! To add, edit or delete steps, click on the "Edit" button near the top-right of the Progress Bar.');

        $progressBar->record('stored');

        // Redirect the user to the video show page
        return redirect()->route('progress-bars.show', [
            'subdomain' => $subdomain,
            'id' => $progressBar->id,
            'edit' => 1
        ]);
    }

    /**
     * Delete a progress bar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroy($subdomain, Guard $auth, Request $request)
    {
        $progressBar = ProgressBar::findOrFail($request->get('progress_bar_id'));

        /*if ($auth->user()->cannot('destroy', $video)) {
            return abort(400, 'You do not have permission to delete this video');
        }*/

        $progressBar->delete();

        // Delete steps
        ProgressBarStep::where('progress_bar_id', '=', $progressBar)->delete();

        // @TODO: Delete step progress

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'The Progress Bar has been successfully deleted!');

        // Redirect the user to the video show page
        return redirect()->route('progress-bars.index', [
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Updates a progress bar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function update($subdomain, Guard $auth, Request $request)
    {
        $id = $request->get('progress_bar_id');

        $progressBar = ProgressBar::findOrFail($id);

        /*if ($auth->user()->cannot('update', $progressBar)) {
            return abort(400, 'You do not have permission to edit this video');
        }*/

        $progressBar->fill([
            'name' => $request->get('name')
        ]);

        $participantIds = with(new GroupRepository)->convertParticipantsToIds(collect($request->input('participants')));

        // Attach the user participants to the video
        $progressBar->participants()->sync($participantIds);

        // If tags were selected for progress bar then add them here
        if ($tags = $request->input('tags')) {
            // Attach the tags to the video
            $progressBar->tags()->sync($tags);
        } else {
            $progressBar->tags()->detach();
        }

        // Send notifications to participants
        $progressBar->record('updated');

        $progressBar->save();

        // Any steps to delete?
        $deleteStepIdsJson = $request->get('delete_step_ids');

        if (!empty($deleteStepIdsJson)) {
            $deleteStepIds = \GuzzleHttp\json_decode($deleteStepIdsJson);

            foreach ($deleteStepIds as $stepId) {
                //dump('Received step ID '+ $stepId +' to delete');
                $step = ProgressBarStep::findOrFail($stepId);
                $step->destroy($stepId);
            }
        }

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your Progress Bar has been successfully updated!');

        // Send the user back to the page they were on
        return redirect()->route('progress-bars.show', [
            'subdomain' => $subdomain,
            'id' => $id
        ]);
    }

    public function updateTemplate($subdomain, Guard $auth, Request $request)
    {
        $id = $request->get('progress_bar_id');
        $isTemplate = $request->get('is_template');

        $progressBar = ProgressBar::findOrFail($id);

        $progressBar->is_template = $isTemplate;

        $progressBar->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success!');
        $request->session()->flash('flash.component', 'vc');

        if ($isTemplate == '1') {
            $request->session()->flash('flash.message', 'Your progress bar has been saved as a template!');
        } else {
            $request->session()->flash('flash.message', 'Your progress bar has been unmarked as a template!');
        }

        // Send the user back to the page they were on
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }

    public function createFromTemplate($subdomain, Guard $auth, Request $request)
    {
        $id = $request->get('progress_bar_id');

        $progressBar = ProgressBar::findOrFail($id);

        // Copy progress bar
        $newProgressBar = ProgressBar::create([
            'author_id' => $auth->user()->id,
            'name' => $request->get('name'),
            'action_plan' => $progressBar->action_plan
        ]);

        $newProgressBar->save();

        // Copy progress bar steps
        if (count($progressBar->steps)) {
            foreach ($progressBar->steps as $step) {
                // Create progress bar tep
                ProgressBarStep::create([
                    'progress_bar_id' => $newProgressBar->id,
                    'author_id' => $auth->user()->id,
                    'name' => $step->name,
                    'link' => $step->link,
                    'type' => $step->type
                ]);
            }
        }

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'You have copied the selected progress bar template!');

        // Send the user back to the page they were on
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Saves a column to this video
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeStep($subdomain, Guard $auth, Request $request)
    {
        // Check if the user has the permission to create a new video column
        /*if ($auth->user()->cannot('create', new VideoColumn)) {
            return abort(400, 'You do not have permission to create a new video');
        }*/

        // Create a new cycle step
        ProgressBarStep::create([
            'progress_bar_id' => $request->get('progress_bar_id'),
            'author_id' => $auth->user()->id,
            'name' => $request->get('step_name'),
            'link' => $request->get('link'),
            'type' => $request->get('type')
        ]);

        // Generate a message for the user
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your step has been added!');

        // Redirect the user to the dashboard
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Saves a step to this progress bar
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeStepAjax($subdomain, Guard $auth, Request $request)
    {
        $dueDate = $request->get('due_date');

        if (!empty($dueDate)) {
            //var_dump('Due date detected: '. $dueDate);
            // Create a new cycle step
            $progressBarStep = ProgressBarStep::create([
                'progress_bar_id' => $request->get('progress_bar_id'),
                'author_id' => $auth->user()->id,
                'name' => $request->get('step_name'),
                'link' => $request->get('link'),
                'type' => $request->get('type'),
                'due_date' => $dueDate,
                'order' => $request->get('order'),
                'participant_id' => '0',//$request->get('participant_id')
                'is_external' => '0',
                'due_date_notified' => '0'//$request->get('')
            ]);
        } else {
            //var_dump('No due date');
            // Create a new cycle step
            $progressBarStep = ProgressBarStep::create([
                'progress_bar_id' => $request->get('progress_bar_id'),
                'author_id' => $auth->user()->id,
                'name' => $request->get('step_name'),
                'link' => $request->get('link'),
                'type' => $request->get('type'),
                'order' => $request->get('order'),
                'participant_id' => '0',//$request->get('participant_id')
                'is_external' => '0',
                'due_date_notified' => '0'//$request->get('')
            ]);
        }


        return response()->json([
            'id' => $progressBarStep->id
        ]);
    }

    /**
     * Updates a step
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function updateStep($subdomain, Guard $auth, Request $request)
    {
        /*$video = Video::findOrFail($id);
        if ($auth->user()->cannot('update', $video)) {
            return abort(400, 'You do not have permission to edit this video');
        }*/

        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        $progressBarStep->fill($request->only('name', 'link', 'type', 'due_date'));

        $progressBarStep->save();

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'Your step has been successfully updated!');

        // Redirect the user to the dashboard
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Updates a step
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function updateStepAjax($subdomain, Guard $auth, Request $request)
    {
        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        $progressBarStep->fill($request->only('name', 'link', 'type', 'due_date', 'type_id', 'desc', 'participant_id', 'is_external'));

        $progressBarStep->save();

        // Redirect the user to the dashboard
        return response(200);
    }

    /**
     * Updates a step's order via AJX
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function updateStepOrderAjax($subdomain, Guard $auth, Request $request)
    {
        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        $progressBarStep->fill($request->only('order'));

        $progressBarStep->save();

        // Redirect the user to the dashboard
        return response(200);
    }

    /**
     * Hide a video an all the information without Destroy it
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroyStep($subdomain, Guard $auth, Request $request)
    {
        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        /*if ($auth->user()->cannot('destroy', $video)) {
            return abort(400, 'You do not have permission to delete this video');
        }*/

        $progressBarStep->destroy($request->get('id'));

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'The step has been successfully deleted!');

        // Redirect the user to the dashboard
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Delete a step
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function destroyStepAjax($subdomain, Guard $auth, Request $request)
    {
        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        $progressBarStep->destroy($request->get('id'));

        return response(['success' => 'success', 200]);
    }

    /**
     * Fetch a step
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function fetchStepAjax($subdomain, Guard $auth, Request $request)
    {
        $progressBarStep = ProgressBarStep::findOrFail($request->get('id'));

        // Fetch participant
        if ($progressBarStep->participant_id) {
            $participant = User::findOrFail($progressBarStep->participant_id);
        } else {
            $participant = null;
        }

        // Fetch if it is completed
        $completed = false;

        $completedQuery = ProgressBarStepProgress::where('progress_bar_step_id', $request->get('id'))
            ->where('completed', '1')
            ->get();

        if ($completedQuery->count()) {
            $completed = true;
        }

        return response(['task' => $progressBarStep, 'participant' => $participant, 'completed' => $completed, 200]);
    }

    /**
     * Fetch a progress bar
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\View\View
     */
    public function fetchProgressBarAjax($subdomain, Guard $auth, Request $request)
    {
        $progressBar = ProgressBar::findOrFail($request->get('id'));

        return response(['progressBar' => $progressBar, 200]);
    }

    public function completeStep($subdomain, Guard $auth, Request $request, $progressBarId, $id)
    {
        $progressBarStepProgress = ProgressBarStepProgress::create([
            'progress_bar_step_id' => $id,
            'participant_id' => $auth->id(),
            'completed' => '1'
        ]);

        // Fetch progress bar
        $progressBar = ProgressBar::findOrFail($progressBarId);
        $pbParticipants = [];

        foreach ($progressBar->participants as $participant) {
            $pbParticipants[] = $participant->id;
        }

        $progressBarStepProgress->participants()->attach($pbParticipants);
        $progressBarStepProgress->record('completed');

        // Show a success message
        $request->session()->flash('flash.title', 'Success');
        $request->session()->flash('flash.component', 'vc');
        $request->session()->flash('flash.message', 'The step has been successfully marked as completed!');

        // Redirect the user to the dashboard
        return redirect()->route('progress-bars.show', [
            'subdomain' => $subdomain,
            'id' => $progressBarId
        ]);
    }

    public function startStep($subdomain, Guard $auth, Request $request, $progressBarId, $id)
    {
        $progressBarStepProgress = ProgressBarStepProgress::create([
            'progress_bar_step_id' => $id,
            'participant_id' => $auth->id(),
            'completed' => '0'
        ]);

        // Fetch progress bar
        $progressBar = ProgressBar::findOrFail($progressBarId);
        $pbParticipants = [];

        foreach ($progressBar->participants as $participant) {
            $pbParticipants[] = $participant->id;
        }

        $progressBarStepProgress->participants()->attach($pbParticipants);
        $progressBarStepProgress->record('started');

        return response(200);
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
        // Get the progressBar the user is commenting on
        $progressBar = ProgressBar::findOrFail($id);

        // If the user doesn't have permission to comment on this progressBar then
        // throw a 403 error
        // @TODO: Implement permissions
        /*if ($auth->user()->cannot('comment', $progressBar)) {
            abort(403, 'You do not have permission to comment on this progressBar');
        }*/

        $parentId = $request->get('parent_id');

        $saved = $progressBar->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        return $saved ? response(['comment_id' => $saved->id], 200) : abort(400);
    }
}
