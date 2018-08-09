<!-- Add Progress Bar Modal -->
<div id="createProgressBarModal" class="modal fade animated" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">New Progress Bar</h4>

            </div>
            <form role="form" method="post" action="{{ route ('progress-bars.store') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    {{--Hidden--}}
                    {{--@if (count($progressBarTemplates) > 0)
                        <div class="row" style="text-align: center;">
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="use_template">
                                    <i class="ti-palette"></i> Choose from Template
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="sep-wrap">
                                    <h2 class="sep-center-line"><span>OR</span></h2>
                                </div>
                            </div>
                        </div>
                    @endif--}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" title="Name" class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tags <span class="text-danger">*</span></label>
                                <select name="tags[]" class="tags form-control required" multiple="multiple" title="Tags" style="width: 100%;" required></select>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tasker <span class="text-danger">*</span></label>
                                <select name="tasker[]" class="participant-single form-control required" title="Tasker" style="width: 100%;" required></select>
                            </div>
                        </div>
                    </div>
                    --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Participants <span class="text-danger">*</span></label>
                                <select name="participants[]" class="participants form-control required" multiple="multiple" title="Participants" style="width: 100%;" required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="add_pb"><span class="glyphicon glyphicon-ok-sign"></span> Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Add Progress Bar Modal -->

<!-- Edit Progress Bar Modal (NEW DESIGN) -->
<div id="editProgressBarModal" class="modal fade animated" role="dialog" aria-labelledby="editProgressBarModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form role="form" method="post" action="{{ route ('progress-bars.update') }}" data-template-action="{{ route('progress-bars.updateTemplate') }}" data-toggle="validator">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Edit Progress Bar</h4>
                </div>
                    {!! csrf_field() !!}
                <input type="hidden" name="progress_bar_id" value="" />
                <input type="hidden" name="is_template" value="" />
                <input type="hidden" name="delete_step_ids" value="" />
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <div class="row justify-content-md-center pb-tasks-edit">
                        <!--<div class="pb-tasks-left">
                            <button class="btn btn-success button-circle pull-left pb-task-add" data-direction="left" id="add_task_prev" style="height:40px;">
                                <i class="ti-plus"></i>
                            </button>
                        </div>-->
                        <div class="text-center">
                            <button class="btn btn-primary" id="edit_task">Edit</button>
                            <div class="well">
                                <p>New Task</p>
                            </div>
                            <button class="btn btn-danger" id="delete_task">Delete</button>
                        </div>
                        <div class="pb-tasks-right">
                            <button class="btn btn-success pull-right pb-task-add" data-direction="right" id="add_task_next" style="height:40px;">
                                <i class="ti-plus"></i> Add Task
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="" placeholder="Name" title="Name" class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tags <span class="text-danger">*</span></label>
                                <select name="tags[]" class="tags form-control required" multiple="multiple" title="Tags" style="width: 100%;" required>
                                @if (isSet($progressBar))
                                    @foreach($progressBar->tags as $tag)
                                        <option value="{{$tag->id}}" selected="selected">{{$tag->tag}}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Participants <span class="text-danger">*</span></label>
                                <select name="participants[]" class="participants form-control required" multiple="multiple" title="Participants" style="width: 100%;" required>
                                    @if (isSet($progressBar))
                                        @foreach($progressBar->participants as $participant)
                                            <option value="{{ $participant->id }}" selected="selected">{{ $participant->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-right" role="group" aria-label="Video actions">
                        <button type="submit" class="btn btn-success" id="save_pb">
                            <span class="glyphicon glyphicon-ok-sign"></span> Save
                        </button>
                        <button type="button" class="btn btn-danger btn-cancel" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> Cancel
                        </button>
                        {{--Hidden--}}
                        {{--@if($user->is('admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher'))
                        <button class="btn btn-primary makeTemplate" id="make_template_btn">
                            <span class="glyphicon glyphicon-list-alt"></span> Mark As Template
                        </button>
                        <button class="btn btn-primary unmakeTemplate" id="unmark_as_template_btn" style="display:none">
                            <span class="glyphicon glyphicon-list-alt"></span> Unmark As Template
                        </button>
                        @endif--}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- / Edit Progress Bar Modal -->

<!-- Select Progress Bar Template Modal -->
<div id="createProgressBarModalFromTemplate" class="modal fade animated" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">New Progress Bar from Template</h4>
            </div>
            <form role="form" method="post" action="{{ route ('progress-bars.createFromTemplate') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <input type="hidden" name="progress_bar_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Template <span class="text-danger">*</span></label>
                                @foreach ($progressBarTemplates as $progressBarTemplate)
                                    <p>
                                        {{ $progressBarTemplate->name }} ({{ count($progressBarTemplate->steps) }} steps)
                                        <button type="submit" class="btn btn-success btn-xs" id="select_template" data-progress-bar-id="{{ $progressBarTemplate->id }}">
                                            <i class="ti-check-box"></i> Use this template
                                        </button>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Select Progress Bar Template Modal -->

<!-- Add/Edit Progress Bar Step Modal -->
<div class="modal fade" id="addEditProgressBarStepModal" tabindex="-1" role="dialog" aria-labelledby="addEditProgressBarStepModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form data-toggle="validator">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                    <h4 class="modal-title" id="addEditProgressBarStepModal">
                        <i class="fa ti-pencil icon-align"></i> Edit Task
                    </h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="errors">

                    </div>
                    <div class="input-group">
                        <input type="hidden" class="task_id" name="id" value="" />
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control required task_name" placeholder="Name" maxlength="60" title="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <input type="text" name="desc" class="form-control required task_desc" placeholder="Description" maxlength="255" title="Description" required>
                        </div>
                        <div class="form-group">
                            <label>Type of Task <span class="text-danger">*</span></label>
                            <select name="type_id" class="form-control task_type_id required" title="Task Type" required>
                                <option value="">-- Select --</option>
                                @foreach ($progressBarStepTypes as $stepType)
                                    <option value="{{ $stepType->id }}">{{ $stepType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="resource-finder" style="display:none">
                            <div class="form-group">
                                <label>Resource Finder</label>
                                <select name="object_type" class="object_type form-control">
                                    <option value="">-- Select --</option>
                                    <option value="1">Internal Resource</option>
                                    <option value="2">External Resource</option>
                                    <option value="3">Nevermind, cancel</option>
                                </select>
                            </div>
                            <div class="form-group obj-cat" style="display:none">
                                <label>Object Category</label>
                                <select name="object_category" class="object_category form-control">
                                    <option value="">-- Select --</option>
                                    <option value="1">Videos</option>
                                    <option value="2">Instructional Design</option>
                                    <option value="3">Resources & Modules</option>
                                    <option value="4">Messages</option>
                                    <option value="5">Discussions</option>
                                </select>
                            </div>
                            <div class="form-group obj" style="display:none">
                                <label>Object </label>
                                <select name="object" class="object form-control">
                                </select>
                            </div>
                        </div>
                        <div class="form-group step-link" style="">
                            <label>Link <span class="text-danger">*</span></label>
                            <input type="text" name="link" class="form-control task_link required" placeholder="Link" title="Link" required>
                        </div>
                        <label>Deadline <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw ti-calendar"></i>
                            </div>
                            <input name="due_date" class="form-control task_due_date datepicker required" id="task_deadline" size="40" value="" placeholder="" title="Deadline" required />
                        </div>
                        <div class="form-group">
                            <label>Participant <span class="text-danger">*</span></label>
                            {{--<select id="participant" name="participants" title="Participant" class="form-control select2 participant-single required" style="width:100%" required></select>--}}
                            <select id="participant" name="participants" class="participant-single form-control required" multiple="multiple" title="Participants" style="width: 100%;" required></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" id="close_step_update" data-dismiss="modal">
                        Cancel
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                    <button type="submit" class="btn btn-success pull-right" id="update_step">
                        <span class="glyphicon glyphicon-ok-sign"></span> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Add/Edit Progress Bar Step Modal -->

<!-- Delete Progress Bar Modal -->
<div class="modal fade" id="deleteProgressBarModal" tabindex="-1" role="dialog" aria-labelledby="deleteProgressBarModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('progress-bars.destroy') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <input type="hidden" name="progress_bar_id" value="" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this progress bar?
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok-sign"></span> Yes
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> No
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Delete Progress Bar Modal Modal -->

<!-- Remove Participant Modal -->
<div class="modal fade" id="removeParticipantModal" tabindex="-1" role="dialog" aria-labelledby="Heading" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
                <h4 class="modal-title custom_align" id="Heading">Delete User</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to remove this participant?
                </div>
            </div>
            <div class="modal-footer ">
                <a href="deleted_users.html" class="btn btn-danger">
                    <span class="glyphicon glyphicon-ok-sign"></span> Yes
                </a>
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
    </div>
</div>
<!-- / Remove Participant Modal -->

<!-- Edit Progress Bar Modal (OLD) -->
<div id="editProgressBarModalOLD" class="modal fade animated" role="dialog" aria-labelledby="editProgressBarModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Edit Progress Bar</h4>

            </div>
            <form role="form" method="post" action="{{ route ('progress-bars.update') }}" data-template-action="{{ route('progress-bars.updateTemplate') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <input type="hidden" name="progress_bar_id" value="" />
                <input type="hidden" name="is_template" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="" placeholder="Name" class="form-control">
                            </div>
                        </div>
                    </div>
                {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                {{--<div class="form-group">--}}
                {{--<label>Action Plan</label>--}}
                {{--<textarea rows="3" name="action_plan" class="form-control resize_vertical no-ck-editor" placeholder="Action Plan..."></textarea>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Participants <span class="text-danger">*</span></label>
                            <select name="participants[]" class="participants form-control" multiple="multiple" title="Participants" style="width: 100%;"></select>
                        </div>
                    </div>
                </div>--}}
                <!-- Progress Bar Steps -->
                    <div class="row">
                        <div class="col-md-12">
                            <label>Progress Bar Tasks</label>
                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addProgressBarStepModal"><i class="ti-plus"></i> Add Task</button>
                            </div>
                            <div class="dd" id="nestable_list_3">
                            </div>
                        </div>
                    </div>
                    <!-- Progress Bar Steps -->
                </div>
                <div class="modal-footer">
                    <div class="btn-group pull-right" role="group" aria-label="Video actions">
                        <button type="submit" class="btn btn-success btn-xs" id="add_column">
                            <i class="ti-check-box"></i> Save
                        </button>
                        <button class="btn btn-primary btn-xs makeTemplate" id="make_template_btn"><i class="ti-check-box"></i> Mark As Template </button>
                        <button class="btn btn-primary btn-xs unmakeTemplate" id="unmark_as_template_btn" style="display:none"><i class="ti-check-box"></i> Unmark As Template </button>
                    </div>

                    <button type="button" class="btn btn-danger btn-xs pull-left delete-pb">
                        <i class="ti-trash"></i> Delete Progress Bar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Edit Progress Bar Modal -->

<script>
    $(document).ready(function() {
        $('.modal').on('hidden.bs.modal', function () {
            $( ".errors" ).empty();
        })
    });
</script>