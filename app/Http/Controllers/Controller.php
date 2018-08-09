<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\ActivityRepository;
use Illuminate\Contracts\Auth\Guard;

use App\ProgressBar;
use App\ProgressBarStep;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct(Guard $auth)
    {
        //$notifications = with(new ActivityRepository)->getActivitiesForUserWhereAuthorIsNotUser($auth->id());
        $notifications = with(new ActivityRepository)->getActivitiesForUserWhereAuthorIsNotUserOnlyUnreadCollection(
            $auth->user()->id,
            10
        );
        
        view()->share('activities', with(new ActivityRepository)->getActivitiesForUser($auth->id()));

        view()->share('notificationsHeader', $notifications);

        view()->share('user', $auth->user());

        //========================================================================================
        // Check if this user has any progress bar steps that are due today
        //========================================================================================
        if ($_SERVER['REMOTE_ADDR'] == '50.205.90.126') {
            /*$dateToday = Carbon::today();

            $progressBars = ProgressBar::with([
                //'tags',
                'steps',
                'steps.usersProgress',
                //'steps.type',
                'participants'])->isParticipant($auth->id())->get();

            if ($progressBars->count()) {
                foreach ($progressBars as $progressBar) {
                    //dump($progressBar);

                    // Loop through each step
                    foreach ($progressBar->steps as $step) {
                        $stepCompleted = false;

                        if ($step->usersProgress->count() == 0) {
                            // The step has not been completed
                        } else {
                            // Need to check if this user has completed the step they are assigned to
                            // and if the step is due today
                            if ($step->participant_id == $auth->user()->id) {
                                //dump($step);

                                // Check if they have completed the step
                                foreach ($step->usersProgress as $stepProgress) {
                                    if ($stepProgress->participant_id == $auth->user()->id &&
                                        $stepProgress->completed == '1') {
                                        $stepCompleted = true;
                                    }
                                }
                            }
                        }

                        if ($step->participant_id == $auth->user()->id &&
                            $stepCompleted == false &&
                            $dateToday->eq($step->due_date) == true) {
                            // Send out notification
                            $step->participants()->sync([$auth->user()->id]);

                            if ($step->due_date_notified == '0') {
                                $step->record('due-today');

                                //dump($step->participants);

                                $UpdateStep = ProgressBarStep::findOrFail($step->id);
                                $UpdateStep->due_date_notified = '1';
                                $UpdateStep->save();
                            }
                            //dump('recorded for step ID '. $step->id);
                        }
                    }

                    //if ($dateToday == $step->)
                }
            }*/
        }
    }
}
