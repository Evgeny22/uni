@extends('layouts.default')

@section('content')

    <script>
        var annotations = {!! $annotations !!};

        var videoColumns = {!! $videoColumns !!};

        videoId = {{ $video->id }};
    </script>

    @include('video-center.popups', [
        'video' => $video,
        'crosscuttingConcepts' => $crosscuttingConcepts,
        'practices' => $practices,
        'coreIdeas' => $coreIdeas
    ])

    <section class="video-center">
        <div class="row normalize-row">
            <div class="col-md-12">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <span class="navbar-brand"><small>Actions</small></span>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="navbar-form navbar-right" role="actions">

                                <a class="btn btn-success" type="button" href="{{ route ('video-center.index') }}">Back to All My Videos</a>
                                @if ($video->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin'))
                                    <button class="icon-edit btn btn-info" type="button" title="Edit Post" data-trigger="edit-post">Edit Video Post</button>

                                    @if ($user->is('mod') or $user->is('super_admin'))
                                        <button class="icon-remove btn btn-danger" type="button" title="Remove Post" data-trigger="remove-post">Delete Video</button>
                                    @else
                                        @if ($requestedDelete)
                                            <button class="icon-remove btn btn-danger" type="button" title="Request to Delete" disabled="disabled">Requested to Delete</button>
                                        @else
                                            <button class="icon-remove btn btn-danger request-delete" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}" type="button" title="Request to Delete">Request to Delete</button>
                                        @endif
                                    @endif
                                @endif

                                <button class="btn btn-primary share-object" href="#" data-toggle="modal" data-target="#shareObjectModal" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}">Share Video</button>

                                @if($isSaved)
                                    <button class="btn btn-warning unsave-object" href="#" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}">Unsave Video</button>
                                @else
                                    <button class="btn btn-warning save-object" href="#" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}">Save Video</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="panel">
                <div class="panel-heading" style="overflow: auto;">
                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                        {{ $video->title }}
                    </h3>
                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                        <div class="row">
                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                <div class="img">
                                    <span class="profile-pic"><img src="{{ $video->author->avatar->url() }}" alt="{{ $video->author->name }}"></span>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="details">
                                    <div class="name">
                                        <small>{{ $video->author->displayName }}</small>
                                    </div>
                                    <div class="time">
                                        <small>
                                            <i class="ti-time"></i>
                                            <span data-class="date-time">{{ $video->created_at->diffForHumans() }}</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="btn-label label-right btn-success pull-right">
                                        <span class="text-white">{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i></span>
                                    </span>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 bord">
                        <div class="row">
                            <div class="col-md-12">
                                @if( !empty($video->description) )
                                    <div class="alert-message alert-message-default">
                                        <small style="color: #adadad;font-size: 10px;"><strong>DESCRIPTION</strong></small>
                                        <p class="description">{!! $video->description !!}</p>
                                    </div>
                                @endif
                                @if($video->participants->count()>0 or $video->tags->count()>0 )
                                    @if($video->participants->count()>0)
                                        <div class="well well-sm">
                                            <small><strong>PARTICIPANTS</strong></small>

                                            @foreach ($video->participants as $participant)

                                                <a href="{{ route('profile', ['id' => $participant->id ]) }}" title="{{ $participant->displayName }}"><img data-name="{{ $participant->displayName }}" class="participant" alt="{{ $participant->displayName }}" /></a>

                                            @endforeach

                                        </div>
                                    @endif
                                    @if($video->tags->count()>0)

                                        <div class="well well-sm">
                                            <small><strong>TAGS</strong></small>
                                            @foreach($video->tags as $tag)

                                                <a href="{{route('video-center.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-xs btn-primary tag">
                                                    <small>{{$tag->tag}}</small>
                                                </a>

                                            @endforeach

                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-8">
                                <article class="module" style="float:none; margin-bottom: 12px;">

                                    <div class="module-content pad-narrow">
                                        <div class="wistia_embed wistia_async_{{ $video->wistia_hashed_id }}" style="min-width:594.6px;min-height:334px;" id="vc-video"></div>

                                        <div id="timeline">

                                            <ul>
                                                <li id="timeline__playhead"><a href="#"></a></li>
                                            </ul>

                                            <span id="timeline__ticker-display-time"></span>

                                        </div>

                                    </div>

                                </article>
                            </div>
                            <div class="col-md-4">
                                @if (count($annotations) > 0)
                                    <div class="panel-group" id="annotations-holder">
                                        <div class="panel panel-faq" style="overflow: auto;">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#annotations-holder" href="#annotations-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                                    <h4 class="panel-title">
                                                        <i class="ti-notepad"></i> Annotations
                                                        <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                </span>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="annotations-{{ $video->id }}" class="panel-collapse collapse in" aria-expanded="true">
                                                <div class="panel-body" style="max-height: 352px;">

                                                    <div class="tab-pane fade active in" id="annotations-{{ $video->id }}">
                                                        <!-- Add Annotation Form -->
                                                        @if ($video->isAuthoredBy($user) or $user->is('super_admin') or $user->is('teacher') or $user->is('master_teacher') or $user->is('mod') or $video->hasParticipant($user))
                                                            <div class="add-annotation">
                                                                <form class="add-annotation-form" method="POST" action="/api/video-center/{{ $video->id }}/annotations">
                                                                    {!! csrf_field() !!}
                                                                    <small><strong>NEW ANNOTATION</strong></small>
                                                                    <button class="btn btn-success btn-xs pull-right video-btn play-video" style="margin-bottom: 2px;">
                                                                        <i class="ti-control-play"></i> Play Video
                                                                    </button>
                                                                    <textarea name="content" rows="2" class="annotation-text form-control resize_vertical no-ck-editor" placeholder="Annotation Notes"></textarea>

                                                                    <div class="timestamp">
                                                                        <div style="display: inline-block;"><small class="text-success"><strong>START</strong></small><br />
                                                                            <input class="minutes_start" name="minutes_start" value="0">
                                                                            <span class="colon">:</span>
                                                                            <input class="seconds_start" name="seconds_start" value="00">
                                                                        </div>

                                                                        <div style="display: inline-block;
    margin: 0 20px;">
                                                                            <small class="text-danger"><strong>END</strong></small><br />
                                                                            <input class="minutes_end" name="minutes_end" value="0">
                                                                            <span class="colon">:</span>
                                                                            <input class="seconds_end" name="seconds_end"  value="00">
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success btn-xs" style="margin-top: 5px;">Save Annotation</button>
                                                                </form>
                                                            </div>
                                                            <hr />
                                                    @endif
                                                    <!-- / Add Annotation Form -->
                                                        <div class="well" style="margin-top: 20px;">
                                                            <small><strong>CURRENT ANNOTATIONS</strong></small>

                                                            <!-- Annotations -->
                                                            <ul class="schedule-cont">

                                                                <div class="annotations">

                                                                </div>

                                                            </ul>
                                                            <!-- / Annotations -->
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="panel-group" id="documents-holder">

                                    <div class="panel panel-faq">
                                        <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#documents-holder" href="#documents-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                                <h4 class="panel-title">
                                                    <i class="ti-agenda"></i> Supporting Documents
                                                    <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                </span>
                                                </h4>
                                            </a>
                                        </div>
                                        <div id="documents-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">

                                                <div class="tab-pane fade active in" id="documents-{{ $video->id }}">
                                                    <div class="well">

                                                        @include('partials.supporting-documents', ['docs' => $video->documents])

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#prompts-holder" href="#prompts-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                            <h3 class="panel-title text-white"><i class="ti-new-window"></i> Prompts
                                                <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                                            </h3>
                                        </a>
                                    </div>
                                    <div id="prompts-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#large_modal">
                                                        Prompt 1
                                                    </button>
                                                </div>
                                            </div>


                                            <div id="large_modal" class="modal fade animated" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                            <h4 class="modal-title">Prompt 1
                                                                <span class="pull-right"><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#viewClipModal" title="View Clip" type="button">
                                            <i class="ti-video-clapper"></i> View Clip
                                        </button></span>
                                                            </h4>

                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="stepwizard">
                                                                <div class="stepwizard-row setup-panel">
                                                                    <div class="stepwizard-step">
                                                                        <a href="#step-1" class="btn btn-primary btn-block">1</a>
                                                                    </div>
                                                                    <div class="stepwizard-step">
                                                                        <a href="#step-2" class="btn btn-default btn-block">2</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <form role="form">
                                                                <div class="row setup-content" id="step-1">
                                                                    <div class="col-xs-12">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                {{--<label for="step_fname" class="control-label">In this clip, lorem ipsum dolor. What sit amet consequter emit?</label>--}}
                                                                                <h4>In this clip, lorem ipsum dolor. What sit amet consequter emit?</h4>
                                                                                <textarea rows="2" class="form-control resize_vertical no-ck-editor" placeholder="Your comments/answers go here..."></textarea>
                                                                            </div>

                                                                            <button class="btn btn-primary nextBtn pull-right" type="button">
                                                                                Next
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row setup-content" id="step-2">
                                                                    <div class="col-xs-12">
                                                                        <div class="col-md-12">
                                                                            <h3> Step 2</h3>
                                                                            <div class="form-group">
                                                                                <label for="step_cname" class="control-label">Company Name</label>
                                                                                <input id="step_cname" maxlength="200" type="text" class="form-control"
                                                                                       placeholder="Enter Company Name"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="step_cadd" class="control-label">Company Address</label>
                                                                                <input id="step_cadd" maxlength="200" type="text" class="form-control"
                                                                                       placeholder="Enter Company Address"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="step_pwd" class="control-label">Password</label>
                                                                                <input id="step_pwd" maxlength="12" type="password" class="form-control"
                                                                                       placeholder="Enter password"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="step_cpwd" class="control-label">Confirm Password</label>
                                                                                <input id="step_cpwd" maxlength="12" type="password"
                                                                                       class="form-control"
                                                                                       placeholder="Confirm password"/>
                                                                            </div>
                                                                            <button class="btn btn-primary prevBtn pull-left" type="button">
                                                                                Previous
                                                                            </button>
                                                                            <button class="btn btn-primary nextBtn pull-right" type="button">
                                                                                Next
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row setup-content" id="step-3">
                                                                    <div class="col-xs-12">
                                                                        <div class="col-md-12">
                                                                            <h3> Step 3</h3>
                                                                            <div class="form-group">
                                                                                <label for="acceptTerms1">
                                                                                    <input id="acceptTerms1" name="acceptTerms" type="checkbox"
                                                                                           class="custom-checkbox"> I agree with the <a
                                                                                            href="javascript:void(0)">terms &amp; Conditions</a>.
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary prevBtn pull-left" type="button">
                                                                                    Previous
                                                                                </button>
                                                                                <button class="btn btn-success pull-right" type="submit">
                                                                                    Finish!
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('partials.exemplar_features')

    @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin']))
        <!-- Columns Functionality -->
            <div class="row columns-details normalize-row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                <h3 class="panel-title text-white"><i class="ti-layers"></i> Columns
                                    <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                                </h3>
                            </a>
                        </div>
                        <div id="columns-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                @if ($videoColumns->count() == 0)
                                    <div class="alert alert-info alert-dismissable" style="width: 90%;display: inline-block;margin-bottom: 1px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong> Head's up!</strong> There are no Columns yet. Click on the <strong><i class="ti-plus"></i></strong> button to get started.
                                    </div>
                                @endif

                                @if ($videoColumns->count() < 5)
                                    <button class="button button-circle button-royal-flat hvr-grow pull-left" data-toggle="modal" data-target="#addColumnModal" style="margin: 6px;
"><i class="ti-plus"></i></button>
                            @endif

                            <!-- Columns List -->
                                <div class="row columns">
                                @foreach($videoColumns as $videoColumnKey => $videoColumn)
                                    @if ($videoColumnKey == 0)
                                        <!-- Individual Column -->
                                            <div class="col-md-2 col-md-offset-1">
                                            @else
                                                <!-- Individual Column -->
                                                    <div class="col-md-2">
                                                    @endif

                                                    <!-- @TODO: panel class needs to change depending on videoColumn.color -->
                                                        <div class="panel panel-primary column column-panel" data-column-id="{{ $videoColumn->id }}">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">
                                                                    {{ $videoColumn->name }}
                                                                </h3>
                                                            </div>
                                                            <div class="panel-body" style="padding: 0 0 0 8px; margin-bottom: -11px;">
                                                                <div class="schedule-cont annotations-in-column">
                                                                    <div class="annotations-in-column" data-video-id="{{ $videoColumn->video_id }}">
                                                                        <ul>
                                                                            <!-- Individual Video Column Object -->
                                                                            @if(isset($videoColumnAnnotations[$videoColumn->id]))
                                                                                @foreach($videoColumnAnnotations[$videoColumn->id] as $annotation)
                                                                                    <li class="annotation item success" data-end="4" data-start="2" data-target="0">
                                                                                        <div class="annotation-details">
                                                                                            <div class="data">
                                                                                                <div class="time text-muted">
                                                                        <span class="date-time">
                                                                            <a class="stamp-link" data-end="4" data-start="2" data-target="0" href="#">@0:02 - 0:04</a>
                                                                        </span>
                                                                                                </div>
                                                                                                <div class="img">
                                                                        <span class="profile-pic">
                                                                            <img alt="#" src="#">
                                                                        </span>
                                                                                                </div>
                                                                                                <div class="details annotation" data-annotation-id="{{$annotation[0]['id']}}">
                                                                                                    <div class="name annotation-details">
                                                                                                        <small>{{ $annotation[0]['content'] }}</small>
                                                                                                        <div class="btn-group" role="group" aria-label="Actions">
                                                                                                            <button class="btn btn-info btn-xs edit-annotation" type="button" title="Edit">Edit </button>
                                                                                                            <button class="btn btn-danger btn-xs remove-annotation" type="button" title="Delete" data-trigger="remove-annotation">Delete</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="time">
                                                                                                        <i class="ti-time"></i> <span data-class="date-time">{{ $annotation[0]['updated_at'] }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group" style="margin-top: 10px;">
                                                                                                    <div aria-label="Actions" class="btn-group" role="group">
                                                                                                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#createPromptModal" title="Create Prompt" type="button">
                                                                                                            <i class="ti-new-window"></i> Create Prompt
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                    <!-- Individual Video Column Object -->
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="column-data" style="display:none;">
                                                                    <span id="column_id">{{ $videoColumn->id }}</span>
                                                                    <span id="column_name">{{ $videoColumn->name }}</span>
                                                                    <span id="column_color">{{ $videoColumn->color }}</span>
                                                                    <span id="video_id">{{ $videoColumn->video_id }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <div class="btn-group" role="group" aria-label="Video actions">
                                                                    <button class="btn btn-info btn-xs edit-column" type="button" title="Edit" data-toggle="modal" data-target="#editColumnModal">Edit</button>

                                                                    <button class="btn btn-danger btn-xs delete-column" type="button" title="Delete">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Individual Column -->
                                                    @endforeach
                                            </div>

                                            <!-- / Columns List -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- / Columns Functionality -->

                <!-- / Admin Comments -->
                <div class="row video-details normalize-row">
                    <div class="col-md-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#adminComments-holder" href="#adminComments-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                    <h3 class="panel-title text-white"><i class="ti-comments"></i> Admin Comments
                                        <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                                    </h3>
                                </a>
                            </div>
                            <div id="adminComments-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body comments">
                                    @include('comments_list', [
                                        'comments' => $video->adminComments
                                    ])

                                    <div class="add-comment full">
                                        @include('forms/new-comment', [
                                            'author' => $video->author,
                                            'message' => $video,
                                            'type' => 'admin'
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Admin Comments -->
        @endif
    </section>

    <!-- Add Column Modal -->
    <div class="modal fade" id="addColumnModal" tabindex="-1" role="dialog" aria-labelledby="addColumnModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="addColumnModalTitle">
                        <i class="fa ti-plus icon-align"></i> Create Column
                    </h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('video-center.column.store') }}">
                        {!! csrf_field() !!}

                        <div class="errors">

                        </div>

                        <div class="input-group">
                            <input type="text" id="column_name" name="column_name" class="form-control" placeholder="Column Name">
                            <input type="hidden" name="video_id" value="{{ $video->id }}" />
                            <select name="column_color">
                                <option value="Blue">Blue</option>
                                <option value="Green">Green</option>
                                <option value="Sky Blue">Sky Blue</option>
                                <option value="Yellow">Yellow</option>
                                <option value="Red">Red</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success pull-left" id="add_column">
                            <i class="fa ti-plus icon-align"></i> Add
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" id="close_column_create" data-dismiss="modal">
                        Close
                        <i class="fa ti-close icon-align"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- / Add Column Modal -->

    <!-- Edit Column Modal -->
    <div class="modal fade" id="editColumnModal" tabindex="-1" role="dialog" aria-labelledby="editColumnModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="editColumnModalTitle">
                        <i class="fa ti-plus icon-align"></i> Edit Column
                    </h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('video-center.column.update') }}">
                        {!! csrf_field() !!}

                        <div class="errors">

                        </div>

                        <div class="input-group">
                            <input type="text" id="column_name" name="name" class="form-control" value="" placeholder="Column Name">
                            <input type="hidden" id="column_id" name="column_id" value="" />
                            <input type="hidden" id="video_id" name="video_id" value="" />
                            <select name="color">
                                <option value="Blue">Blue</option>
                                <option value="Green">Green</option>
                                <option value="Sky Blue">Sky Blue</option>
                                <option value="Yellow">Yellow</option>
                                <option value="Red">Red</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success pull-left" id="edit_column">
                            <i class="fa ti-plus icon-align"></i> Edit Column
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" id="close_column_create" data-dismiss="modal">
                        Cancel
                        <i class="fa ti-close icon-align"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- / Add Column Modal -->

    <!-- Add Prompt Modal -->
    <div aria-hidden="true" class="modal fade animated" id="createPromptModal" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(102, 204, 153);border-radius: 6px 6px 0 0;">
                    <button class="close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">Create Prompt</h4>
                </div>
                <form role="form">
                    <div class="modal-body">
                        <div class="row m-t-10">
                            <div class="col-md-12">
                                <small class="text-muted"><strong>TIMESTAMP</strong></small>
                                <div class="timestamp">
                                    <div style="display: inline-block;">
                                        <small class="text-success"><strong>START</strong></small><br>
                                        <input class="minutes_start" name="minutes_start" type="number" value="00">
                                        <span class="colon">:</span>

                                        <input class="seconds_start" name="seconds_start" type="number" value="02">
                                    </div>

                                    <div style="display: inline-block;
margin: 0 20px;">
                                        <small class="text-danger"><strong>END</strong></small><br>
                                        <input class="minutes_end" name="minutes_end" type="number" value="00">
                                        <span class="colon">:</span>
                                        <input class="seconds_end" name="seconds_end" type="number" value="04">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-t-10">
                            <small class="text-muted"><strong>PROMPT TITLE</strong></small>
                            <div class="input-group">
                                <input type="text" id="inputUsername4" class="form-control" placeholder="Prompt 1" value="Prompt 1">
                            </div>
                        </div>
                        <div class="form-group m-t-10">
                            <small class="text-muted"><strong>OBSERVATION NOTES</strong></small>
                            <textarea class="form-control resize_vertical m-t-10 no-ck-editor" id="message" name="message" rows="2">wewdsad</textarea>
                        </div>
                        <div class="form-group m-t-10">
                            <small class="text-muted"><strong>ACTION PLAN GOALS</strong></small>
                            <textarea class="form-control resize_vertical m-t-10 no-ck-editor" id="message" name="message" placeholder="Action Plan Goals" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#prompt_modal_1">
                                    Prompt Question 1
                                </button>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#prompt_modal_1">
                                    Prompt Question 2
                                </button>
                                <div id="prompt_modal_1" class="modal fade animated" role="dialog" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                                <h4 class="modal-title">Prompt Question 1</h4>
                                            </div>
                                            <form role="form">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <label for="prompt-question">Prompt Question Label</label>
                                                                <input type="text" name="prompt-question" id="prompt-question" placeholder="Prompt Question 1" class="form-control m-t-10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">
                                                        Cancel
                                                        <i class="fa ti-close icon-align"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success pull-left" id="add-new-prompt-question" data-dismiss="modal">
                                                        <i class="fa ti-plus icon-align"></i> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"> <a href="#" class="btn btn-success btn-block btn-sm" data-toggle="modal" data-target="#addPromptQuestion"><i class="ti-plus"></i> Add</a></div>

                        </div>

                        <div class="modal fade" id="addPromptQuestion" tabindex="-1" role="dialog" aria-labelledby="addPromptQuestion" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="addPromptQuestion"> Create Prompt Question
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Prompt Question Label</label>
                                            <textarea class="form-control resize_vertical m-t-10 no-ck-editor" placeholder="Prompt Question Label" rows="2" id="message"></textarea>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">
                                            Cancel
                                            <i class="fa ti-close icon-align"></i>
                                        </button>
                                        <button type="button" class="btn btn-success pull-left" id="add-new-prompt-question" data-dismiss="modal">
                                            <i class="fa ti-plus icon-align"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-xs" type="submit"><i class="ti-new-window"></i> Create Prompt</button>
                        {{--<button class="btn btn-danger" data-dismiss="modal" type="button"><i class="ti-close"></i> Close</button>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Add Prompt Modal -->

    <!-- View Clip Modal -->
    <div aria-hidden="true" class="modal fade animated" id="viewClipModal" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(102, 204, 153);border-radius: 6px 6px 0 0;">
                    <button class="close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">Clip <strong>{{ $video->title }}</strong></h4>
                </div>
                <form role="form">
                    <div class="modal-body">
                        <script>
                            $(document).on('click', 'button[data-target="#viewClipModal"]', function(e) {

                                if ($('#viewClipModal').hasClass("in")) {
                                    console.log('nothing executed');
                                } else {
                                    //load wistia code
                                    window._wq = window._wq || [];
                                    _wq.push({
                                        id: "{{ $video->wistia_hashed_id }}",
                                        options: {
                                            time: "4.0"
                                        }
                                    });
                                    console.log('wistia modal executed');
                                }
                            });

                        </script>

                        <div class="wistia_embed wistia_async_{{ $video->wistia_hashed_id }}" style="max-width:594.6px;max-height:334px;" id="modal-video"></div>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / View Clip Modal -->

    <script src="{{ app('request')->root() }}/js/custom_js/form_wizards.js" type="text/javascript"></script>
    <script src="{{ app('request')->root() }}/js/custom_js/calendar_custom.js" type="text/javascript"></script>
@endsection