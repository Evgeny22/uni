<?php
$pbClass = '';

if ($progressBars->count() > 1) {
    $pbClass = 'pb-list-view';
}

?>

<!-- Individual Progress Bar -->
@foreach($progressBars as $progressBar)
    <div id="progrssbar-{{ $progressBar->id }}" class="panel panel-default progressbar {{ $pbClass }} pb-list-view dev-pb" data-progress-bar-id="{{ $progressBar->id }}" data-name="{{ $progressBar->name }}" data-is-template="{{ $progressBar->is_template }}" data-tags="{{ $progressBar->tagArray }}" data-complete-orders="{{ isSet($pbCompleteOrders) ? $pbCompleteOrders : '' }}">
        <span class="progress-bar-action-plan" style="display:none;">{{ $progressBar->action_plan }}</span>
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="{{ route('progress-bars.show', ['id' => $progressBar->id]) }}">{{ $progressBar->name }}</a>
            </h3>
            <span class="pull-right">
                <div class="btn-group pull-right" role="group" aria-label="Actions" style="position: relative; top:-3px;">
                    @if (isSet($singleView) && $singleView == true)
                        @if ($progressBar->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin') or $user->is('coach') or $user->is('master_teacher'))
                            <button class="btn btn-warning btn-sm edit-progress-bar" data-toggle="modal" data-target="#editProgressBarModal" title="Edit Progress Bar" type="button">Edit Progress Bar</button>
                        @endif

                        @if ($user->is('mod') or $user->is('super_admin'))
                            <button class="icon-remove btn btn-danger btn-sm delete-pb" type="button" title="Remove Progress Bar" data-pb-id="{{ $progressBar->id }}">Delete</button>
                        @endif
                    @else
                        <a href="{{ route('progress-bars.show', ['id' => $progressBar->id]) }}"><button class="btn btn-warning btn-sm edit-progress-bar"  title="View Progress Bar" type="button">View Progress Bar</button></a>
                    @endif
                </div>
            </span>
        </div>

        <!-- Steps for Edit -->
        <div class="progress-bar-steps-edit" data-progress-bar-id="{{ $progressBar->id }}" style="display:none;">
            @foreach ($progressBar->steps as $step)
                <div class="text-center pb-task" data-task-id="{{ $step->id }}" data-task-name="{{ $step->name }}" data-task-link="{{ $step->link }}" data-task-type="{{ $step->type }}">
                    <span id="task_id" style="display:none">{{ $step->id }}</span>
                    <button type="button" class="btn btn-warning pb-task-edit" id="edit_task">Edit</button>
                    <div class="well" style="margin:20px 0;">
                        <p class="task-name" style="margin: 0 auto;padding: 24px 0;">
                            {{ $step->name }}
                        </p>
                        <p class="task-order">
                            Order: <span class="text-danger">*</span>
                            <input class="step-order-edit required" type="number" style="width:40px; margin: 0 auto;" value="{{ $step->order }}" title="Order for Step {{ $step->name }}" />
                        </p>
                    </div>
                    <button type="button" class="btn btn-danger pb-task-delete" id="delete_step" data-task-id="{{ $step->id }}">Delete</button>
                </div>
            @endforeach
            <div class="pb-tasks-right">
                <button class="btn btn-success pull-right pb-task-add" data-direction="right" id="add_task_next" style="height:40px;">
                    <i class="ti-plus"></i> Add Task
                </button>
            </div>
        </div>
        <!-- / Steps for Edit -->

        <!-- Steps -->
        <div class="panel-body">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    @if (count($progressBar->steps) == 0)
                        No tasks have been added.
                    @endif

                        <?php

                        // Determines which task is "active"
                        $activeIndex = 0;

                        // Only make the current task "active"
                        // The current task is i + 1 of the completed task

                        // If there is no progress for any tasks, then only make the first task active

                        if (isSet($pbStepsCompletedByPBId[$progressBar->id]) && count($pbStepsCompletedByPBId[$progressBar->id]) == $progressBar->steps->count()) {
                            // All tasks completed
                            //echo '<pre>all tasks completed.</pre>';

                        } elseif (isSet($pbStepsCompletedByPBId[$progressBar->id])) {
                            // One ore more tasks are completed
                            foreach ($progressBar->steps as $sI => $s) {
                               // debug($pbStepsCompletedByPBId[$progressBar->id]);

                                // Check if this task is complete
                                if (in_array($s->id, $pbStepsCompletedByPBId[$progressBar->id])) {
                                    //echo '<pre>STEP ID '. $s->id .' COMPLETED!</pre>';
                                    $activeIndex = $sI + 1;
                                }
                            }

                            //echo '<pre>not all tasks are completed.</pre>';
                            //echo '<pre>active index: '. $activeIndex .'</pre>';
                        } else {
                            // No tasks are completed
                            //echo '<pre>no tasks are completed.</pre>';
                        }

                        ?>

                        <!-- Individual Step -->
                        <?php

                            $previousStepCompleted = true;

                        ?>

                        @foreach ($progressBar->steps as $i => $step)
                            <?php

                            if (isSet($pbStepsProgressByPBId[$progressBar->id])) {
                                //dump(['i' => $i, 'step' => $pbStepsProgressByPBId[$progressBar->id][$step->id]]);
                            }

                            $previousStepId = $i !== 0 ? $progressBar->steps[$i - 1]->id : $step->id;

                            if (isSet($pbStepsProgressByPBId[$progressBar->id]) && $pbStepsProgressByPBId[$progressBar->id][$previousStepId] == '0') {
                                $previousStepCompleted = false;
                            }

                            if ($i == 0) {
                                $previousStepCompleted = true;
                            }

                            /*$previousStepId = $i !== 0 ? $progressBar->steps[$i - 1]->id : $step->id;

                            if (isSet($pbStepsCompletedByPBId[$progressBar->id])) {
                                if (isSet($pbStepsCompletedByPBId[$progressBar->id][$previousStepId])) {
                                    $previousStepCompleted = true;
                                }
                            }*/

                            ?>

                            {{--@if (isSet($step->usersProgress) && isSet($pbStepProgress[$step->id][$step->participant_id]))--}}
                            @if ($step->latestProgress['completed'] == 1)
                               <div class="stepwizard-step completed">
                            @else
                               {{-- Check if this step is active --}}
                               @if ($activeIndex == $i)
                                   <div class="stepwizard-step active">
                               @else
                                   <div class="stepwizard-step completed-0">
                               @endif
                            @endif

                               <span class="task-btn-wrapper">
                                   <a type="button" class="btn btn-block pb-task-a completed-0 pb-block" title="" style="margin-bottom:10px;margin-left:10px;"
                                  data-step-id="{{ $step->id }}"
                                  data-container="body"
                                  data-step-type="{{ $step->type }}"
                                  data-placement="bottom"
                                  data-html="true"
                                  data-title="Actions <button type='button' class='btn btn-xs btn-danger popover-close pull-right' data-close='{{ $i }}'>&times;</button>"
                                  @if (isSet($singleView))
                                       data-toggle="popover"
                                  {{--data-trigger="click"--}}
                                  @endif
                                  {{-- Only the most recent, uncompleted task can either be Started or Completed --}}
                                  @if ($previousStepCompleted == true)
                                      @if ($user->id == $step->participant_id)
                                          {{--@if (isSet($pbStepProgress[$step->id][$user->id]))--}}
                                      @if ($step->progress['completed'] == 1)
                                          data-content="<div><strong class='text-success'><span class='ti-check'></span>Completed</strong></div>
                                                               @if (!empty($step->desc))
                                                  <div>{{ $step->desc }}</div>
                                                               @endif"
                                          @else
                                          data-content="<div class='ui-group-buttons'>
                                                           <a href='{{ $step->link }}'
                                                               {{--@if ($step->is_external == '1')--}}
                                                                   target='_blank'
                                                               {{--@endif--}}
                                                               data-start-url='{{ route('progress-bars.steps.startStep', ['id' => $step->id, 'progressBarId' => $progressBar->id]) }}' class='btn btn-primary start-step' role='button'>
                                                                       <span class='ti-pencil-alt'></span> Start
                                                                   </a>
                                                                   <div class='or'></div>
                                                                   <a href='{{ route('progress-bars.steps.completeStep', ['id' => $step->id, 'progressBarId' => $progressBar->id]) }}' class='btn btn-success' role='button'>
                                                                       <span class='ti-check-box'></span> Mark Complete
                                                                   </a>
                                                               </div>
                                                               <div>
                                                                   <p>Due: <strong>{{ $step->due_date->format('m/d/Y') }}</p>
                                                               </div>

                                                               @if (!empty($step->desc))
                                                               <div>{{ $step->desc }}</div>
                                                               @endif
                                                  </div>"
                                           @endif
                                      @else
                                           data-content="<p>You are not assigned to this task.</p>"
                                      @endif
                                   @else
                                       data-content="<p>The previous task must be completed before this task can be started or completed.</p>"
                                   @endif
                                       >
                                       @if (strLen($step->name) >= 45)
                                           <p class="task-title long">{{ $step->name }}</p>
                                       @else
                                           <p class="task-title">{{ $step->name }}</p>
                                       @endif
                                   </a>
                               </span>
                               <div class="pb_user">
                                   <!-- Participant -->
                                  <a
                                      href="http://educare.inreact-umiami-coachingup.us-east-2.elasticbeanstalk.com/profile/{{ isSet($step->participant) && isSet($step->participant->id) ? $step->participant->id : '' }}"
                                      data-avatar-url="{{ isSet($step->participant) && isSet($step->participant->avatar_url) ? $step->participant->avatar_url : '/avatars/original/missing.jpg' }}"
                                      data-toggle="tooltip"
                                      data-tooltip="tooltip"
                                      data-placement="right"
                                      data-original-title="{{ isSet($step->participant) && isSet($step->participant->displayName) ? $step->participant->displayName . ' (' . $step->participant->role->display_name . ') ' : '' }}">
                                       <img
                                           class="participant-alt @if (isSet($step->participant) && $step->participant->role->id == '3' or isSet($step->participant) && $step->participant->role->id == '6' or isSet($step->participant) && $step->participant->role->id == '8') coach @else teacher @endif"
                                           alt=""
                                           src="{{ isSet($step->participant) && isSet($step->participant->avatar_url) ? $step->participant->avatar_url : '/avatars/original/missing.jpg' }}">
                                   </a>
                               </div>

                           </div>
                       @endforeach
                       <!-- / Individual Step -->
               {{--@endif--}}
                       </div>
               </div>

               </div>
               <!-- / Steps -->

               <!-- Users -->
               <div class="panel-footer">
                   <!-- Individual Participant -->
                   @foreach($progressBar->participants as $participant)
                       <div class="pb_user">
                           <a href="{{ route('profile', ['id' => $participant->id ]) }}" data-avatar-url="{{ $participant->avatar->url() }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="{{ isSet($participant) && isSet($participant->displayName) ? $participant->displayName . ' (' . $participant->role->display_name . ') ' : '' }}">
                               <img class="participant-alt @if (isSet($participant) && $participant->role->id == '3' or isSet($participant) && $participant->role->id == '6' or isSet($participant) && $participant->role->id == '8') coach @else teacher @endif" alt="" src="{{ isSet($participant) && isSet($participant->avatar_url) ? $participant->avatar_url : '/avatars/original/missing.jpg' }}">
                           </a>
                       </div>
                       {{-- @endif--}}
                   @endforeach
               </div>
               <!-- / Users -->

               <!-- Tags and Meta Info -->
               <div class="panel-footer panel-footer-last">
                   <div class="row">
                       <div class="col-md-8">
                           @foreach($progressBar->tags as $tag)
                               <a href="/progress-bars/search?_token={{ csrf_token() }}&search=1&search_tags[]={{$tag->id}}" class="btn btn-xs btn-primary tag">
                                   <sm>{{$tag->tag}}</sm>
                               </a>
                           @endforeach
                       </div>
                       <div class="col-md-4">
                           <div class="pull-right" style="font-size: 85%;position: relative;top: 4px;">
                               Created by
                               <a href="{{ route('profile', ['id' => $progressBar->author->id ]) }}">
                                   {{ $progressBar->author->displayName }}
                               </a>
                               on
                               {{ $progressBar->created_at->format('F j, Y \a\t h:ia') }}
                           </div>
                       </div>
                   </div>
               </div>
               <!-- Tags and Meta Info -->
           </div>
            @if (isSet($pbCenterView) && $pbCenterView == true)
            <script>
                $(document).ready(function() {
                    $("#progrssbar-{{ $progressBar->id }} .panel-body a").popover('disable').attr("href", "{{ route('progress-bars.show', ['id' => $progressBar->id]) }}")
                });
            </script>
            @endif
@endforeach
<!-- Individual Progress Bar -->

   @if ($progressBars->count() == 1)
       @php($progressBar = $progressBars[0])
           <div class="row video-details normalize-row">
               <div class="col-md-12">
                   <div class="panel panel-danger">
                       <div class="panel-heading">
                           <a data-toggle="collapse" data-parent="#comments-holder" href="#comments-{{ $progressBar->id }}" class="collapsed" aria-expanded="false">
                               <h3 class="panel-title text-white"><i class="ti-comments"></i> Comments
                                   <span class="pull-right">
                                   <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                               </span>
                               </h3>
                           </a>
                       </div>
                       @if ($progressBar->comments->count() == 0)
                           <div id="comments-{{ $progressBar->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                           </div>
                       @else
                           <div id="comments-{{ $progressBar->id }}" class="panel-collapse collapse in" aria-expanded="true">
                               @endif

                               <div class="panel-body">
                                   @include('comments_list', [
                                       'comments' => $progressBar->comments,
                                       'can_reply' => true
                                   ])

                                   <div class="add-comment full">
                                       @include('forms/new-comment', [
                                           'author' => $user,
                                           'progressBar' => $progressBar,
                                       ])
                                   </div>
                               </div>
                           </div>
                   </div>
               </div>
           </div>
       @endif