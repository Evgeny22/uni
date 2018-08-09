@extends('layouts.default')

@section('content')



    <script>
        var annotations = {!! $annotations !!};

        var videoColumns = {!! $videoColumns !!};
        //var videoColumns = {!! $videoColumns->where('author_id', $user->id) !!};

        videoId = {{ $video->id }};
    </script>

    @include('video-center.popups', [
        'video' => $video,
        'crosscuttingConcepts' => $crosscuttingConcepts,
        'practices' => $practices,
        'coreIdeas' => $coreIdeas
    ])
    <div id="right-annotations">
        <div id="right-slim">
            <div class="rightsidebar-right">
                <div class="rightsidebar-right-content">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="r_tab">
                            <div id="slim_t2">
                                <h5 class="rightsidebar-right-heading text-uppercase text-xs">
                                    <i class="fa fa-fw ti-notepad"></i>
                                    Current Annotations
                                </h5>
                                <div class="well annotations-container" style="margin: 20px 0 10px; display: none;">
                                    <ul class="schedule-cont">

                                        <div class="annotations">

                                        </div>

                                    </ul>
                                    <!-- / Annotations -->
                                </div>

                                <div class="alert alert-info empty-annotations" style="margin: 20px 0 10px; display: none;">
                                    <strong>
                                        Head's up!
                                    </strong>&nbsp;
                                    There are no annotations for this video yet.
                                </div>
                                <button id="close-side" class="btn btn-danger btn-cancel btn-sm pull-right">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                {{--@if ($pendingMode == '1')
                                    <button class="btn btn-success" data-trigger="exemplar-response-approve">Approve Resource Request</button>
                                    <button class="btn btn-danger" data-trigger="exemplar-response-deny">Deny Resource Request</button>
                                @elseif ($deleteMode == '1')
                                    <a href="{{ route('request-delete.approve', [
                                    'id' => $deleteId]) }}">
                                        <button class="btn btn-success" data-id="{{ $deleteId }}">Approve Delete Request</button>
                                    </a>
                                    <a href="{{ route('request-delete.deny', [
                                    'id' => $deleteId]) }}">
                                        <button class="btn btn-danger" data-trigger="delete-response-deny" data-id="{{ $deleteId }}">Deny Delete Request</button>
                                    </a>
                                @elseif ($recoverMode == '1')
                                    <a href="{{ route('request-recover.approve', [
                                    'id' => $recoverId]) }}">
                                        <button class="btn btn-success" data-id="{{ $recoverId }}">Approve Recover Request</button>
                                    </a>
                                    <a href="{{ route('request-recover.deny', [
                                    'id' => $recoverId]) }}">
                                        <button class="btn btn-danger" data-trigger="delete-response-deny" data-id="{{ $recoverId }}">Deny Recover Request</button>
                                    </a>
                                @else--}}
                                    <a class="btamv" type="" href="{{ route ('video-center.index') }}"><< Back to All My Videos</a>

                                    @if($video->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin') or $user->is('teacher') or $user->is('coach'))
                                    <button class="btn btn-success btn-sm share-object" href="#" data-toggle="modal" data-target="#shareObjectModal" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}" data-author-id="{{ $video->author_id }}" data-user-id="{{ $user->id }}">Share Video</button>
                                    @endif

                                    {{--Hidden--}}
                                    @if($isSaved)
                                        <button class="btn btn-success btn-sm unsave-object" href="#" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}">Unbookmark Video</button>
                                    @else
                                        <button class="btn btn-success btn-sm save-object" href="#" data-object-id="{{ $video->id }}" data-object-type="{{ get_class($video) }}">Bookmark Video</button>
                                    @endif

                                    @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin', 'coach']))
                                        @if ($video->isExemplar && $video->exemplar()->approved == true && $user->isEither(['super_admin', 'project_admin']))
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exemplar-remove">Remove as Resource</button>
                                        @elseif ($video->isExemplar && $video->exemplar()->approved == true && $user->isEither(['coach', 'master_teacher']))

                                        @else
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exemplar-request">Make a Resource</button>
                                        @endif
                                    @endif
                                    @if ($video->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin'))
                                        <button class="icon-edit btn btn-warning btn-sm" type="button" title="Edit Post" data-toggle="modal" data-target="#edit-video">Edit Video Post</button>
                                        <button class="icon-remove btn btn-danger btn-sm" type="button" title="Remove Post" data-toggle="modal" data-target="#remove-video">Delete Video</button>
                                    @endif
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            {{--@if ($video->participants->count() > 0)
            <div class="well well-sm">
                <small><strong>PARTICIPANTS</strong></small>

                <a href="{{ route('video-center.show.participant', ['id' => $video->id, 'participantId' => $video->author->id ]) }}" title="{{ $video->author->name }}">
                    @if ($viewingParticipantId == $video->author->id)
                        <strong>{{ $video->author->name }}</strong>
                    @else
                        {{ $video->author->name }}
                    @endif
                </a>

                @if ($video->participants->count()>0)
                    @foreach ($video->participants as $participant)
                        <a href="{{ route('video-center.show.participant', ['id' => $video->id, 'participantId' => $participant->id ]) }}" title="{{ $participant->displayName }}">
                            @if (isSet($viewingParticipantId) && $viewingParticipantId == $participant->id)
                                <strong>{{ $participant->displayName }}</strong>
                            @else
                                {{ $participant->displayName }}
                            @endif
                        </a>
                    @endforeach
                @endif
            </div>
            @endif--}}

            @if ($user->is('admin') or $user->is('mod') and count($sharedWithList) > 0)
                <div class="well well-sm">
                        <small><strong>PARTICIPANTS</strong></small>

                @foreach ($sharedWithList as $shareId => $sharedWithRecipient)
                    <a href="{{ route('video-center.show.participant', ['id' => $video->id, 'participantId' => $sharedWithRecipient->id ]) }}" title="{{ $sharedWithRecipient->name }}">
                        @if (isSet($viewingParticipantId) && $viewingParticipantId == $sharedWithRecipient->id)
                            <strong>{{ $sharedWithRecipient->name }}</strong>
                        @else
                            {{ $sharedWithRecipient->name }}
                        @endif
                    </a>
                @endforeach
                    </div>
            @endif


            <div class="panel">
                <div class="panel-heading" style="overflow: auto;">
                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                        {{ $video->title }}
                    </h3>
                    <div class="col-md-6 bord">
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
                                            <span data-class="date-time">{{ $video->created_at->format('m/d/y') }}</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @if( !empty($video->description) )
                    <div class="row description-row col-md-12">
                            {{--<small><strong>DESCRIPTION</strong></small>--}}
                            <p>{!! $video->description !!}</p>
                    </div>
                @endif


                </div>
                <div class="panel-body video-container">
                    <div class="col-md-12 bord">
                        <div class="row">
                            <div class="col-md-12">
             
                                @if($video->participants->count()>0 or $video->tags->count()>0 )
                                    @if($video->participants->count()>0)
                                        {{--<div class="well well-sm participant-pics">--}}
                                            {{--<small><strong>PARTICIPANTS</strong></small>--}}

                                            {{--@foreach ($video->participants as $participant)--}}
                                                {{--<a href="{{ route('profile', ['id' => $participant->id ]) }}" title="{{ $participant->displayName }}"><img src="{{ $participant->avatar->url() }}" class="profile-pic" alt="{{ $participant->displayName }}" /></a>--}}
                                            {{--@endforeach--}}

                                        {{--</div>--}}
                                    @endif
                                    @if(isSet($video->tags) && $video->tags->count()>0)
                                        {{--<div class="well well-sm">--}}
                                            {{--<small><strong>TAGS</strong></small>--}}
                                            {{--@foreach($video->tags as $tag)--}}
                                                {{--<a href="{{route('video-center.index')."/search?search=1&search_tags[]=". $tag->id}}" class="btn btn-xs btn-primary tag">--}}
                                                    {{--<small>{{$tag->tag}}</small>--}}
                                                {{--</a>--}}
                                            {{--@endforeach--}}

                                        {{--</div>--}}
                                    @endif
                                @endif
                            </div>
                            <div class="col-sm-8">
                                <article class="module" style="float:none; margin-bottom: 12px;">
                                    <div class="module-content pad-narrow">
                                        <!--<div class="wistia_embed wistia_async_{{ $video->wistia_hashed_id }}" style="min-width:594.6px;min-height:334px;" id="vc-video"></div>-->
                                            <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;">
                                                <div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;">
                                                    <div class="wistia_embed wistia_async_{{ $video->wistia_hashed_id }} fullscreenButton=false playButton=false playbackRateControl=false qualityControl=false settingsControl=false googleAnalytics=false" id="vc-video" style="height:416px;width:auto;">&nbsp;</div></div></div>

                                            {{--<iframe src="//fast.wistia.net/embed/iframe/{{ $video->wistia_hashed_id }}" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="620" height="349"></iframe>--}}


                                            <div id="timeline">

                                            <ul>
                                                <li id="timeline__playhead"><a href="#"></a></li>
                                            </ul>

                                            <span id="timeline__ticker-display-time"></span>

                                        </div>

                                    </div>

                                </article>
                            </div>
                            <div class="col-sm-4">
                                @if ($user->is('super_admin') or $user->is('master_teacher') or $user->is('coach') or $user->is('mod'))
                                    @if (count($annotations) > 0)
                                        <div class="panel-group" id="annotations-holder">
                                            <div class="panel panel-faq" style="overflow: auto;">
                                                <div class="panel-heading">
                                                    <i class="ti-notepad"></i> Annotations
                                                    {{--Hidden--}}
                                                    <input name="column_color" type="color" value="#0000FF" style="display:none;" disabled>
                                                    <input type="checkbox" name="no_column" value="1" checked style="display:none;"> {{--No Label--}}
                                                </div>
                                                <div id="annotations-{{ $video->id }}" class="panel-collapse collapse in" aria-expanded="true">
                                                    <div class="panel-body" style="max-height: 352px;">

                                                        <div class="tab-pane fade active in" id="annotations-{{ $video->id }}">
                                                            <!-- Add Annotation Form -->
                                                            @if ($video->isAuthoredBy($user) or $user->is('super_admin') or $user->is('master_teacher') or $user->is('coach') or $user->is('mod') or $video->hasParticipant($user))
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
                                                                            <div style="display: inline-block;margin: 0 20px;">
                                                                                <small class="text-danger"><strong>END</strong></small><br />
                                                                                <input class="minutes_end" name="minutes_end" value="0">
                                                                                <span class="colon">:</span>
                                                                                <input class="seconds_end" name="seconds_end"  value="00">
                                                                            </div>
                                                                        </div>
                                                                        <p>
                                                                            <button type="submit" class="btn btn-success btn-xs" style="margin-top: 5px;">Save Annotation</button>
                                                                        </p>
                                                                    </form>
                                                                </div>
                                                                <hr />
                                                        @endif
                                                        <!-- / Add Annotation Form -->
                                                        {{--@if (count($annotations) > 0)--}}
                                                            <div class="annotations-container" style="margin: 20px 0 0; display: none;">
                                                                <h6><strong>CURRENT ANNOTATIONS</strong><br/><a href="javascript:void(0)" class="toggle-right-annotations btn btn-xs btn-warning"><i class="fa fa-fw ti-angle-double-left"></i> Expand Annotations</a></h6>
                                                                <ul class="schedule-cont">

                                                                    <div class="annotations">

                                                                    </div>

                                                                </ul>
                                                                <!-- / Annotations -->
                                                            </div>

                                                            <div class="alert alert-info empty-annotations" style="margin: 20px 0 -5px; display: block;">
                                                                <strong>
                                                                    Head's up!
                                                                </strong>&nbsp;
                                                                There are no annotations for this video yet.
                                                            </div>
                                                        {{--@endif--}}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        @if($discussions->count() == 0)
                                            <a data-toggle="collapse" data-parent="#prompts-holder" href="#prompts-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                                <h3 class="panel-title text-white"><i class="ti-new-window"></i> Discussions
                                                    <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                </span>
                                                </h3>
                                            </a>
                                        @else
                                            <a data-toggle="collapse" data-parent="#prompts-holder" href="#prompts-{{ $video->id }}" class="collapsed" aria-expanded="true">
                                                <h3 class="panel-title text-white"><i class="ti-new-window"></i> Discussions
                                                    <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                                                </h3>
                                            </a>
                                        @endif
                                    </div>
                                    @if ($discussions->count() == 0)
                                        <div id="prompts-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    @else
                                        <div id="prompts-{{ $video->id }}" class="panel-collapse collapse in" aria-expanded="true">
                                    @endif
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    @if (isSet($_GET['dev']) && $_GET['dev'] == '1')
                                                    <button type="button" class="btn btn-primary open-discussion" data-discussion-id="dev" style="width: 85%!important; margin: 5px 0px 5px 0px;" data-toggle="modal" data-target="#discussion-dev">
                                                        _DEVELOPMENT DISCUSSION
                                                    </button>
                                                    @endif

                                                    @if($discussions->count() > 0)
                                                        @foreach ($discussions as $discussion)
                                                            <div class="discussion-button" data-discussion-id="{{$discussion->id}}">
                                                                @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin', 'coach', 'mod']) or $discussion->isAuthoredBy($user))
                                                                    <button type="button" class="btn btn-primary open-discussion" data-discussion-id="{{$discussion->id}}" style="width: 83%!important; margin: 0px 0px 5px 0px;" data-toggle="modal" data-target="#discussion-{{$discussion->id}}">
                                                                        {{ $discussion->title }}
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-primary open-discussion" data-discussion-id="{{$discussion->id}}" style="width: 83%!important; margin: 0px 0px 5px 0px;" data-toggle="modal" data-target="#discussion-{{$discussion->id}}">
                                                                        {{ $discussion->title }}
                                                                    </button>
                                                                @endif

                                                                @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin', 'coach', 'mod', 'teacher']) or $discussion->isAuthoredBy($user))
                                                                    {{--<button type="button" class="btn btn-primary edit-discussion" data-discussion-id="{{$discussion->id}}" data-toggle="modal" data-target="#edit-discussion-{{$discussion->id}}">
                                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger pull-left" id="delete_discussion" data-discussion-id="{{$discussion->id}}">
                    <span class="glyphicon glyphicon-trash"></span> Delete
                </button>
                                                                    --}}
                                                                        <div class="dropdown pull-right">
                                                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                                <span class="glyphicon glyphicon-cog"></span>
                                                                                <span class="caret"></span>
                                                                            </button>
                                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                                <li><a class="edit-discussion" data-discussion-id="{{$discussion->id}}" data-toggle="modal" data-target="#edit-discussion-{{$discussion->id}}">Edit</a></li>
                                                                                <li><a id="delete_discussion" data-discussion-id="{{$discussion->id}}">Delete</a></li>
                                                                            </ul>
                                                                        </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-info">
                                                            <strong>Heads up!</strong> There are currently no discussions.
                                                        </div>
                                                    @endif

                                                        @if ($user->is('super_admin') or $user->is('master_teacher') or $user->is('coach') or $user->is('mod') or $user->is('teacher'))
                                                            {{--<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#createPromptWithoutAnnotationModal">
                                                                Create Discussion
                                                            </button>--}}
                                                            <button type="button" class="btn btn-primary btn-block create-discussion-no-ann" data-video-id="{{ $video->id }}">
                                                                Create Discussion
                                                            </button>
                                                        @endif
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

    @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin', 'coach', 'mod']))
        <!-- Columns Functionality -->
            <div class="row columns-details normalize-row" id="columns-list">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            @if ($videoColumns->count() == 0)
                                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-{{ $video->id }}" class="collapsed" aria-expanded="false">
                                    <h3 class="panel-title text-white"><i class="ti-layers"></i> Columns
                                        <span class="pull-right">
                                            <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                        </span>
                                    </h3>
                                </a>
                            @else
                                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-{{ $video->id }}" aria-expanded="true">
                                    <h3 class="panel-title text-white"><i class="ti-layers"></i> Columns
                                        <span class="pull-right">
                                            <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                        </span>
                                    </h3>
                                </a>
                            @endif
                        </div>
                        @if ($videoColumns->count() == 0)
                        <div id="columns-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        @else
                        <div id="columns-{{ $video->id }}" class="panel-collapse collapse in" aria-expanded="true">
                        @endif
                            <div class="panel-body" style="min-height:200px;">
                                @if ($videoColumns->count() == 0)
                                    <div class="alert alert-info alert-dismissable" style="width: 90%;display: inline-block;margin-bottom: 1px;">
                                        <strong> Head's up!</strong> There are no Columns yet. Click the "Create New Column" button to get started.
                                    </div>
                                @endif

                                {{--@if ($videoColumns->count() < 5)--}}
                                    <button class="btn btn-success pull-left new-col" data-toggle="modal" data-target="#addColumnModal" style="margin: 6px;">Create New Column</button>
                                {{--@endif--}}

                            <!-- Columns List -->

                                <div class="row columns">

                                @foreach($videoColumns as $videoColumnKey => $videoColumn)
                                    @if ($videoColumnKey == 0)
                                        <!-- Individual Column -->
                                        <div class="col-md-12 col-md-offset-1 column-container" data-column-id="{{ $videoColumn->id }}">
                                    @else
                                        <!-- Individual Column -->
                                        <div class="col-md-2 column-container" data-column-id="{{ $videoColumn->id }}">
                                    @endif
                                    @if ($videoColumn->author_id == $user->id)

                                        <!-- @TODO: panel class needs to change depending on videoColumn.color -->
                                            <div class="panel panel-primary column column-panel" data-column-id="{{ $videoColumn->id }}">
                                                <div class="panel-heading" style="background:{{$videoColumn->color}}">
                                                    <h3 class="panel-title">
                                                        {{ $videoColumn->name }}

                                                        <!--<div class="btn-group" role="group" aria-label="Column actions">
                                                            <button class="btn btn-info btn-xs edit-column" type="button" title="Edit" data-toggle="modal" data-target="#editColumnModal">Edit</button>

                                                            <button class="btn btn-danger btn-xs delete-column" type="button" title="Delete">Delete</button>
                                                        </div>-->
                                                            <!-- Only show for the author -->
                                                            @if ($videoColumn->author_id == $user->id)
                                                            <div class="dropdown pull-right">
                                                                <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <span class="glyphicon glyphicon-cog"></span>
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <li><a class="edit-column" data-toggle="modal" data-target="#editColumnModal">Edit</a></li>
                                                                    {{--Hidden--}}
                                                                    {{--<li><a class="share-column">Share</a></li>--}}
                                                                    <li><a class="delete-column">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                            @endif
                                                    </h3>
                                                </div>
                                                <div class="panel-body" style="padding: 0 0 0 8px; margin-bottom: -11px;">
                                                    <div class="schedule-cont annotations-in-column">
                                                        <div class="annotations-in-column" data-column-id="{{ $videoColumn->id }}" data-video-id="{{ $videoColumn->video_id }}">
                                                            <ul class="js-annotations-in-column">
                                                                <!-- Individual Video Column Object -->
                                                                @if(isset($videoColumnAnnotations[$videoColumn->id]))
                                                                    @foreach($videoColumnAnnotations[$videoColumn->id] as $annotation)
                                                                        @if (isSet($annotation[0]['id']))
                                                                            <li class="annotation item success" data-end="{{$annotation[0]['time_end']}}" data-start="{{ $annotation[0]['time_start'] }}" data-video-column-object-id="{{ $annotation[0]['video_column_object_id'] }}" data-annotation-id="{{  $annotation[0]['id'] }}" data-target="0">
                                                                                <div class="dropdown pull-right">
                                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                                        <span class="glyphicon glyphicon-cog"></span>
                                                                                        <span class="caret"></span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                                        {{--<li><a class="edit-annotation">Edit</a></li>--}}
                                                                                        @if ($videoColumn->author_id == $user->id)
                                                                                            <li><a class="remove-annotation-from-column">Delete </a></li>
                                                                                            <li role="separator" class="divider"></li>
                                                                                        @endif
                                                                                        @if($user->is('super_admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher'))
                                                                                        <li><a class="create-discussion">Create Discussion</a></li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="annotation-details">
                                                                                <div class="data">
                                                                                    <div class="time text-muted">
                                                            <span class="date-time">
                                                                @if ($annotation[0]['time_end'] == '0')
                                                                    <a class="stamp-link" data-end="{{$annotation[0]['time_end']}}" data-start="{{ $annotation[0]['time_start'] }}" data-target="0" href="#">@ {{ gmdate("i:s", $annotation[0]['time_start']) }}</a>
                                                                @else
                                                                    <a class="stamp-link" data-end="{{$annotation[0]['time_end']}}" data-start="{{ $annotation[0]['time_start'] }}" data-target="0" href="#">@ {{ gmdate("i:s", $annotation[0]['time_start']) }} - {{ gmdate("i:s", $annotation[0]['time_end']) }}</a>
                                                                @endif
                                                            </span>
                                                                                    </div>
                                                            {{--<div class="img">
                                                            <span class="profile-pic">
                                                                <img alt="#" src="#">
                                                            </span>
                                                            </div>--}}
                                                                                    <div class="annotation-content">{{ $annotation[0]['content'] }}</div>
                                                                                    {{--<div class="details annotation" data-annotation-id="{{$annotation[0]['id']}}">
                                                                                        <div class="name annotation-details">

                                                                                            <div class="btn-group" role="group" aria-label="Actions">
                                                                                                <button class="btn btn-info btn-xs edit-annotation" type="button" title="Edit">Edit </button>
                                                                                                <button class="btn btn-danger btn-xs remove-annotation" type="button" title="Delete" data-trigger="remove-annotation">Delete</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>--}}
                                                                                    {{--<div class="form-group" style="margin-top: 10px;">
                                                                                        <div aria-label="Actions" class="btn-group" role="group">
                                                                                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#createPromptModal" title="Create Discussion" type="button">
                                                                                                <i class="ti-new-window"></i> Create Discussion
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>--}}

                                                                                </div>
                                                                            </div>
                                                                            </li>
                                                                            <!-- Individual Video Column Object -->
                                                                        @endif
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
                                            </div>
                                        </div>
                                            @endif
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

                <!-- Admin Comments -->
                {{--Hidden--}}
                {{--<div class="row video-details normalize-row">
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
                            @if ($video->adminComments->count() == 0)
                                <div id="adminComments-{{ $video->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                </div>
                                @else
                                <div id="adminComments-{{ $video->id }}" class="panel-collapse collapse in" aria-expanded="true">
                            @endif

                                <div class="panel-body">
                                    @include('comments_list', [
                                        'comments' => $video->adminComments,
                                        'can_reply' => true
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
                </div>--}}
                <!-- / Admin Comments -->
        @endif
    </section>

    <!-- Add Column Modal -->
    <div class="modal fade" id="addColumnModal" tabindex="-1" role="dialog" aria-labelledby="addColumnModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('video-center.column.store') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="addColumnModalTitle">
                        Create New Column
                    </h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="errors">

                    </div>

                    <div class="input-group">
                        <input type="hidden" name="video_id" value="{{ $video->id }}" />
                        <input type="hidden" name="annotation_id" value="" />
                        <label for="column_name">Column Name <span class="text-danger">*</span></label>
                        <p><input type="text" id="column_name" name="column_name" title="Column Name" class="form-control required"></p>
                        <label for="column_color">Column Color <span class="text-danger">*</span></label>
                        <p><input name="column_color" type="color" value="#0000FF" style="width:125px" class="form-control required"></p>
                    </div>
                    {{--<button type="submit" class="btn btn-success pull-left" id="add_column">
                        <i class="fa ti-plus icon-align"></i> Add
                    </button>--}}
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-danger pull-right" id="close_column_create" data-dismiss="modal">
                        Close
                        <i class="fa ti-close icon-align"></i>
                    </button>--}}
                    <button type="submit" class="btn btn-success" id="add_column">
                        <span class="glyphicon glyphicon-ok-sign"></span> Create
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Add Column Modal -->

    <!-- Edit Column Modal -->
    <div class="modal fade" id="editColumnModal" tabindex="-1" role="dialog" aria-labelledby="editColumnModal" aria-hidden="true" style="display: none;">
        <form method="post" action="{{ route('video-center.column.update') }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="editColumnModalTitle">
                            Edit Column
                        </h4>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <div class="errors">

                        </div>

                        <div class="input-group">
                            <input type="hidden" id="column_id" name="column_id" value="" />
                            <input type="hidden" id="video_id" name="video_id" value="" />

                            <label for="column_name">Column Name <span class="text-danger">*</span></label>
                            <p><input type="text" id="column_name" name="column_name" title="Column Name" class="form-control required"></p>
                            <label for="column_color">Column Color <span class="text-danger">*</span></label>
                            <p><input type="color" id="column_color" name="column_color" title="Column Color" value="#0000FF" style="width:125px" class="form-control required"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="edit_column">
                            <span class="glyphicon glyphicon-ok-sign"></span> Update
                        </button>
                        <button type="button" class="btn btn-danger" id="close_column_create" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- / Add Column Modal -->

    <!-- Add Prompt Modal -->
    <div aria-hidden="true" class="modal fade animated" id="createPromptModal" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <form method="post" action="{{ route('video.discussion.store', ['id' => $video->id]) }}" data-toggle="validator">
                <input type="hidden" id="annotation_id" name="annotation_id" value="" />
                {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">Create Discussion</h4>
                </div>
                <form role="form" data-toggle="validator">
                    <div class="modal-body">
                        <div class="errors"></div>
                        <div class="form-group m-t-10">
                            <small class="text-muted"><strong>Title</strong> <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input type="text" name="title" class="form-control required" title="Title" required placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group m-t-10 tag-box">
                            <label for="participants[]" class="control-label">
                                <small class="text-muted"><strong>Participants</strong> <span class="text-danger">*</span></small>
                            </label>
                            <select id="participants[]" required name="participants[]" class="form-control select2 participants required" multiple="multiple" style="width:100%" title="Participants">
                            </select>
                        </div>
                        {{--<div class="form-group m-t-10">--}}
                            {{--<small class="text-muted"><strong>Annotation</strong> <span class="text-danger">*</span></small>--}}
                            {{--<textarea class="form-control resize_vertical m-t-10 no-ck-editor required" title="Annotation" id="message" name="message" rows="2" disabled="disabled"></textarea>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6"><a href="#" class="btn btn-success btn-block btn-sm add-prompt-question"><i class="ti-plus"></i> New Question/Comment</a></div></div>
                                <div class="questions-list">
                                    <div class="question">
                                        <div class="form-group m-t-10">
                                            <p><small class="text-muted"><strong class="question-label">Comment/Question #1</strong>  <span class="text-danger">*</span></small></p>
                                            <input type="text" name="question[]" value="" required title="Question #1" class="form-control question-input" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="add_discussion">
                            <span class="glyphicon glyphicon-ok-sign"></span> Create Discussion
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
    <!-- / Add Prompt Modal -->

    <!-- Add discussion with multiple annotations or no annotations + with participants Modal -->
    <div aria-hidden="true" class="modal fade animated" id="createPromptWithoutAnnotationModal" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <form method="post" action="{{ route('video.discussion.store', ['id' => $video->id]) }}" data-toggle="validator">
                <input type="hidden" id="annotation_id" name="annotation_id" value="0" />
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">×</button>
                        <h4 class="modal-title">Create Discussion</h4>
                    </div>
                    <form role="form">
                        <div class="modal-body">
                            <div class="errors"></div>
                            <div class="form-group m-t-10">
                                <small class="text-muted"><strong>Title</strong> <span class="text-danger">*</span></small>
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control required" required title="Title" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group m-t-10 tag-box">
                                <label for="participants[]" class="control-label">
                                    <small class="text-muted"><strong>Participants</strong> <span class="text-danger">*</span></small>
                                </label>
                                <select id="participants[]" required name="participants[]" class="form-control select2 participants required" multiple="multiple" style="width:100%" title="Participants">
                                </select>
                            </div>
                            @if (!$user->is('teacher'))
                            <div class="form-group m-t-10">
                                <small class="text-muted"><strong>Annotation</strong></small>
                                <select name="annotation_ids[]" class="form-control select2 discussion-annotations-list" multiple="multiple">
                                    @foreach ($annotationsModel as $annotation)
                                        <option value="{{$annotation->id}}" data-start="{{$annotation->time_start}}" data-end="{{$annotation->time_end}}">{{$annotation->content}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="questions-list">
                                        <div class="question">
                                            <div class="form-group m-t-10">
                                                <p><small class="text-muted"><strong class="question-label">Comment/Question #1</strong>  <span class="text-danger">*</span></small></p>
                                                <input required type="text" name="question[]" value="" title="Question #1" class="form-control question-input" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-success btn-block btn-sm add-prompt-question"><i class="ti-plus"></i> New Question/Comment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="add_discussion_without_annotation">
                                <span class="glyphicon glyphicon-ok-sign"></span> Create Discussion
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <!-- / Add discussion with multiple annotations or no annotations Modal -->

    @if ($discussions->count() > 0)
        @foreach ($discussions as $discussion)
            <!-- View/Reply to Prompt/Discussion Modal Discussion ID# {{$discussion->id}} -->
            <div id="discussion-{{$discussion->id}}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;"><div class="modal-backdrop fade in"></div>
                {{--<form method="post" action="{{ route('video.discussion.respond', ['id' => $video->id]) }}" data-save-draft-url="{{ route('video.discussion.respond', ['id' => $video->id]) }}">
                    <input type="hidden" name="discussion_id" value="{{$discussion->id}}">
                    {!! csrf_field() !!}--}}
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h4 class="modal-title">
                                    {{$discussion->title}}
                                    @if ($discussion->annotation_id != 0)
                                        <span class="pull-right ">
                                        <div class="discussion-annotation" data-start="{{$discussion->originalAnnotation->time_start}}" data-end="{{$discussion->originalAnnotation->time_end}}">
                                            <span class="range"></span>
                                        </div>
                                            </span>
                                    @endif
                                </h4>
                            </div>
                            <div class="modal-body">

                                <!-- Individual Question -->
                                @if ($discussion->questions->count() > 0)
                                    @foreach ($discussion->questions as $question)
                                        <?php

                                        // Calculate number of answers
                                        $numAnswers = 0;

                                        if ($question->answers->count() > 0) {
                                            foreach ($question->answers as $answer) {
                                                if ($answer->is_draft == '0') {
                                                    $numAnswers++;
                                                }
                                            }
                                        }

                                        ?>
                                <div class="panel panel-primary">
                                    <!-- Question Name, Author & Date Posted -->
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-{{$question->id}}" aria-expanded="false" class="collapsed">

                                            <h3 class="panel-title text-white">{{$question->question}} <br />
                                                <div class="question-author">
                                                    <img src="{{ $question->author->avatar->url() }}" height="20" width="20" class="img-circle" alt="{{ $question->author->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $question->author->display_name }}" /> <small>{{$question->author->display_name}} {{$question->created_at->format('D, d M Y H:i a')}}</small>

                                                    <span style="display: none;">
                                                        {{--<span class="pull-right">--}}
                                                        {{--@if ($numAnswers > 0)--}}
                                                        {{--<span class="label bg-info">{{$numAnswers}}--}}
                                                        {{--<?php if ($numAnswers == 1) { echo 'Response'; } else { echo 'Responses'; } ?>--}}
                                                        {{--</span>--}}
                                                        {{--@endif--}}
                                                        {{--<i class="fa fa-fw panel-indicator ti-angle-up"></i>--}}
                                                        {{--</span>--}}

                                                    </span>
                                                </div>
                                            </h3>
                                        </a>
                                    </div>

                                    <!-- / Question Name, Author & Date Posted -->

                                    <!-- Question Answers & Comments Container -->
                                    <?php
                                    $questionTextarea = '';

                                    foreach ($question->answers as $answer) {
                                        if ($answer->is_draft == '1' && $answer->author_id == $user->id) {
                                            $questionTextarea .= $answer->answer;
                                        }
                                    }

                                    ?>

                                    <div id="columns-dev-{{$question->id}}" class="panel-collapse collapse" aria-expanded="false" style="">
                                        <div class="panel-body" style="min-height:200px;">


                                                {{--<label class="control-label">{{ $numAnswers }} Replies</label><hr />--}}

                                                <!-- Answer Container -->

                                                @foreach ($question->answers as $answer)
                                                {{--@if ($answer->comments->count() > 0)--}}
                                                    {{--<div class="alert alert-info empty-annotations" style="margin: 20px 0 -5px; display: block;">--}}
                                                        {{--<strong>--}}
                                                            {{--Head's up!--}}
                                                        {{--</strong>&nbsp;--}}
                                                        {{--No has replied to the question yet.--}}
                                                    {{--</div>--}}
                                                @if ($answer->is_draft == '0')
                                                        <div class="alert-message alert-message-default">
                                                <div class="answer-container" data-delete-url="{{ route('video.discussion.answer.destroy', ['id' => $answer->id]) }}" data-answer-id="{{ $answer->id }}">
                                                    <blockquote class="answer">
                                                        <div class="timeline-panel" style="display:inline-block;">
                                                            <div class="timeline-heading">
                                                                <p>
                                                                    <small class="text-default-gray">
                                                                        <a href="{{ route('profile', ['id' => $answer->author->id]) }}">
                                                                            {{--<img data-name="{{ $answer->author->display_name }}" class="participant" alt="{{ $participant->displayName }}"  />--}}
                                                                        </a>
                                                                        <a href="{{ route('profile', ['id' => $answer->author->id]) }}" class="author">
                                                                            {{$answer->author->display_name}}
                                                                        </a>
                                                                        {{$answer->created_at->format('D, d M Y H:i a')}}
                                                                    </small>
                                                                </p>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <p>
                                                                    {{$answer->answer}}
                                                                </p>
                                                            </div>

                                                            <div class="timeline-footer">
                                                                <div class="btn-group pull-right" role="group" aria-label="Actions" style="margin-top: 5px;">
                                                                    <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="{{$answer->id}}">
                                                                        Reply
                                                                    </button>

                                                                    {{-- If this answer has any comments, it cannot be deleted --}}
                                                                    @if ($answer->comments->count() > 0)
                                                                        @if ($user->is('super_admin') or $user->is('mod') or $answer->isAuthoredBy($user))
                                                                            {{--<button class="btn btn-xs btn-action btn-danger" id="cannot_delete_answer">--}}
                                                                                {{--Delete--}}
                                                                            {{--</button>--}}
                                                                        @endif
                                                                    @else
                                                                        @if ($user->is('super_admin') or $user->is('mod') or $answer->isAuthoredBy($user))
                                                                            <button class="btn btn-xs btn-action btn-danger" id="delete_answer" data-answer-id="{{ $answer->id }}">
                                                                                Delete
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </blockquote>

                                                    <div class="comments">
                                                        @include('comments_list', [
                                                            'comments' => $answer->comments,
                                                            'can_reply' => false
                                                        ])
                                                    </div>
                                                    <!-- / Answer Container -->
                                                </div>
                                                        </div>
                                                    @endif
                                                @endforeach




                                            <div class="well">
                                                <form method="post" action="{{ route('video.discussion.respond', ['id' => $video->id]) }}" data-save-draft-url="{{ route('video.discussion.saveDraft', ['id' => $video->id]) }}" data-toggle="validator">
                                                    <input type="hidden" name="discussion_id" value="{{$discussion->id}}">
                                                    {!! csrf_field() !!}
                                                    <div class="errors"></div>
                                                    <label for="answers[{{$question->id}}]" class="control-label">Your Reply</label>
                                                    <textarea required name="answers[{{$question->id}}]" title="{{$question->question}}" class="required is-popup">{{$questionTextarea}}</textarea>
                                                    <br />

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info pull-left" id="save_discussion_response_draft">
                                                            Save Draft
                                                        </button>

                                                        <button type="submit" class="btn btn-success" id="submit_discussion_response">
                                                            <span class="glyphicon glyphicon-ok-sign"></span> Submit
                                                        </button>

                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                            <span class="glyphicon glyphicon-remove"></span> Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @if ($numAnswers == 0)
                                        <div class="panel-footer">
                                            {{--<a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-{{$question->id}}" class="btn btn-danger"><i class="fa fa-fw panel-indicator ti-angle-up"></i> Collapse</a>--}}
                                            <button class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#edit-discussion-{{$discussion->id}}">Edit</button>

                                            <button class="btn btn-danger btn-sm pull-right" id="delete_discussion" data-discussion-id="{{ $discussion->id }}">Delete</button>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- / Question Answers & Comments Container -->

                                </div>
                                <!-- / Individual Question -->
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                {{--</form>--}}
            </div>

<!-- Edit Prompt/Discussion Modal Discussion ID# {{$discussion->id}} -->
<div id="edit-discussion-{{$discussion->id}}" class="modal fade animated editDiscussionModal" role="dialog">
<form method="post" action="{{ route('video.discussion.update', ['id' => $discussion->id]) }}">
    <input type="hidden" name="discussion_id" value="{{$discussion->id}}" />
    {!! csrf_field() !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    Edit Discussion
                    <p>Discussion created by {{ $discussion->author->display_name }} on {{ $discussion->created_at->diffForHumans() }}</p>
                </h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                <p>
                    <label for="title[]" class="control-label">
                        <small class="text-muted"><strong>Title</strong> <span class="text-danger">*</span></small>
                    </label>
                    <input type="text" class="form-control required" name="title" value="{{$discussion->title}}" />
                </p>
                @if ($discussion->originalAnnotation)
                <div class="well well-lg">
                    <em>Original Annotation</em>
                    <pre>{{ $discussion->originalAnnotation->content }}</pre>
                </div>
                @endif

                @if ($discussion->annotation_id != 0)
                    <div class="well discussion-annotation" data-start="{{$discussion->originalAnnotation->time_start}}" data-end="{{$discussion->originalAnnotation->time_end}}">
                        <p>
                            Annotation Range: <span class="range"></span>
                        </p>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-success btn-block btn-sm add-prompt-question"><i class="ti-plus"></i> New Question/Comment</a>
                    </div>
                </div>

                <div class="form-group m-t-10 tag-box">
                    <label for="participants[]" class="control-label">
                        <small class="text-muted"><strong>Participants</strong> <span class="text-danger">*</span></small>
                    </label>
                    <select id="participants[]" name="participants[]" class="form-control select2 participants required" multiple="multiple" style="width:100%" title="Participants">
                        @foreach($discussion->participants as $participant)
                            <option value="{{ $participant->id }}" selected="selected">{{ $participant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="questions-list">
                @if ($discussion->questions->count() > 0)
                    @for ($i = 1; $i <= $discussion->questions->count(); $i++)
                        <?php $question = $discussion->questions[$i - 1]; ?>
                        <div class="question" data-question-id="{{$question->id}}">
                            <div class="form-group m-t-10">
                                <p>
                                    <small class="text-muted">
                                        <strong class="question-label">Comment/Question #{{$i}}</strong>
                                        <span class="text-danger">*</span>
                                    </small>

                                    <button type="button" class="btn btn-small btn-danger pull-right" id="delete_question" data-discussion-id="{{$question->id}}">
                                        <i class="ti-trash"></i>
                                    </button>
                                </p>

                                <input type="text" name="question[{{$question->id}}]" title="Question #{{$i}}" class="form-control question-input" value="{{$question->question}}"/>
                            </div>
                        </div>
                    @endfor
                @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="update_discussion">
                    <span class="glyphicon glyphicon-ok-sign"></span> Update
                </button>
                <button type="button" class="btn btn-danger cancel-btn-edit-discussion" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
            </div>
        </div>
    </div>
</form>
</div>
@endforeach
@endif
<!-- / View Prompt/Discussion Modal -->

<!-- Question Answer Comment Modal -->
{{--<div class="modal fade" id="questionAnswerCommentModal" tabindex="-1" role="dialog" aria-labelledby="questionAnswerCommentModal" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"> Respond to Answer
    </h4>
</div>
<div class="modal-body">
    <div class="add-comment">
        @include('forms/new-answer-comment', [
            'author' => $user,
            'video' => $video,
            'type' => 'user'
        ])
    </div>
</div>
</div>
</div>
</div>--}}


<div class="modal fade animated" id="questionAnswerCommentModal" tabindex="-1" role="dialog" aria-labelledby="questionAnswerCommentModal">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"> Reply to Answer
    </h4>
</div>
<div class="modal-body">
    <!-- <div class="add-comment"> -->
        @include('forms/new-answer-comment', [
            'author' => $user,
            'video' => $video,
            'type' => 'user'
        ])
    <!-- </div> -->
</div>
</div>
</div>
</div>
<!-- / Question Answer Comment Modal -->

<!-- Add Prompt Modal -->
<div aria-hidden="true" class="modal fade animated" id="questionAnswerCommentModal" role="dialog" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header" style="background-color: rgb(102, 204, 153);border-radius: 6px 6px 0 0;">
    <button class="close" data-dismiss="modal" type="button">×</button>
    <h4 class="modal-title">Respond to Answer</h4>
</div>
<div class="modal-body">
    <div class="errors"></div>
    <div class="add-comment full">
        @include('forms/new-answer-comment', [
            'author' => $user,
            'video' => $video,
            'type' => 'user'
        ])
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success" id="add_discussion">
        <span class="glyphicon glyphicon-ok-sign"></span> Create Discussion
    </button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span> Cancel
    </button>
</div>
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
                var secondsStart = $(this).attr('data-clip-start'),
                    secondsEnd = $(this).attr('data-clip-end');

                console.log({'clip_sec_start': secondsStart, 'clip_sec_end': secondsEnd});

                if ($('#viewClipModal').hasClass("in")) {
                    console.log('nothing executed');
                } else {
                    //load wistia code
                    window._wq = window._wq || [];
                    _wq.push({
                        id: "{{ $video->wistia_hashed_id }}",
                        options: {
                            time: "4.0"
                        },
                        onHasData: function(video) {
                            video.time(secondsStart);

                            video.play();

                            video.bind("secondchange", function(s) {
                                console.log('view clip wistia.secondchange called');

                                if (s === secondsEnd) {
                                    video.pause();
                                }
                            });
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

<!-- Shared With List -->
<div class="shared-with" style="display: none;">
<div class="row">
<div class="col-md-12">
@if (count($sharedWithList))
<p>You have shared this with the following users:</p>
@foreach ($sharedWithList as $shareId => $sharedWithRecipient)
    <p>
        {{ $sharedWithRecipient->name }} <button class="btn btn-warning unshare-object" data-share-id="{{ $shareId }}" data-object-type="{{ get_class($video) }}">Unshare with user</button>
    </p>

@endforeach
@endif
</div>
</div>
</div>

<!-- / Shared With List -->

<!-- Not Used -->
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
<!-- / Not Used -->

<!-- OSI EDIT HERE -->
<div id="discussion-dev" class="modal fade" role="dialog" aria-hidden="true" style="display: none;"><div class="modal-backdrop fade in"></div>
<form method="post" action="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/329/discussion/respond" data-save-draft-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/329/discussion/saveDraft">
<input type="hidden" name="discussion_id" value="111">
<input type="hidden" name="_token" value="6sMAeSdnxuCLZYB7seyiRMeoOFF6qzSqxBsXK16y">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">
            Discussion with many questions
        </h4>

    </div>
    <div class="modal-body">
        <div class="errors"></div>

        <div class="panel panel-primary">

            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-1" aria-expanded="false" class="collapsed">
                    <h3 class="panel-title text-white"><i class="ti-write"></i> Question: Where was the man? <br />
                               <div class="question-author">
                                   <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;"> <small>ESI 20 hours ago</small>
                        <span class="pull-right">
                            <i class="fa fa-fw panel-indicator ti-angle-up"></i>
                        </span>
                               </div>

                    </h3>
                </a>
            </div>

            <div id="columns-dev-1" class="panel-collapse collapse" aria-expanded="false" style="">
                <div class="panel-body" style="min-height:200px;">
                    <div class="well">
                        <label for="answers[157]" class="control-label">Your Reply</label>
                        <textarea name="answers[157]" title="Where was the man?" class="required is-popup"></textarea>
                        <br />

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success pull-left" id="submit_discussion_response">
                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                            </button>


                            <button type="button" class="btn btn-info" id="save_discussion_response_draft">
                                <span class="glyphicon glyphicon-hdd"></span> Save As Draft
                            </button>




                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> Cancel
                            </button>
                        </div>
                    </div>

                    <div class="alert-message alert-message-default">
                        <label class="control-label">2 Replies</label><hr />
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/174/destroy" data-answer-id="174">
                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                    <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami, FL.
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>

                            <!--<div class="alert alert-info alert-dismissable" style="margin: 0 18px;">
<strong> Heads up!</strong> There are no comments yet.
</div>-->

                            <div class="comments"></div>

                        </div>
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/180/destroy" data-answer-id="180">


                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                    <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami Beach!
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>



                            <div class="comments">
                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="566" id="comment-id-566" data-comment-index="0">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    What makes you think he was in Miami Beach, Demo Teacher?
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="567" id="comment-id-567" data-comment-index="1">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    I think he was in Miami Beach because his license plate was a Miami Beach license plate, ESI.
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/567/comments" data-comment-id="567">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="569" id="comment-id-569" data-comment-index="2">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    Ok, that makes sense Demo Teacher, thank you!
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/569/comments" data-comment-id="569">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" id="delete_discussion" data-discussion-id="104">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </div>
            </div>

        </div>
        <div class="panel panel-primary">

            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-2" aria-expanded="false" class="collapsed">
                    <h3 class="panel-title text-white"><i class="ti-write"></i> Question: How old is he? <br />
                        <div class="question-author">
                            <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;"> <small>ESI 20 hours ago</small>
                        <span class="pull-right">
                            <i class="fa fa-fw panel-indicator ti-angle-up"></i>
                        </span>
                        </div>

                    </h3>
                </a>
            </div>

            <div id="columns-dev-2" class="panel-collapse collapse" aria-expanded="false" style="">
                <div class="panel-body" style="min-height:200px;">
                    <div class="well">
                        <label for="answers[157]" class="control-label">Your Reply</label>
                        <textarea name="answers[157]" title="Where was the man?" class="required is-popup"></textarea>
                        <br />

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success pull-left" id="submit_discussion_response">
                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                            </button>


                            <button type="button" class="btn btn-info" id="save_discussion_response_draft">
                                <span class="glyphicon glyphicon-hdd"></span> Save As Draft
                            </button>




                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> Cancel
                            </button>
                        </div>
                    </div>

                    <div class="alert-message alert-message-default">
                        <label class="control-label">2 Replies</label><hr />
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/174/destroy" data-answer-id="174">
                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                    <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami, FL.
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>

                            <!--<div class="alert alert-info alert-dismissable" style="margin: 0 18px;">
<strong> Heads up!</strong> There are no comments yet.
</div>-->

                            <div class="comments"></div>

                        </div>
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/180/destroy" data-answer-id="180">


                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                    <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami Beach!
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>



                            <div class="comments">
                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="566" id="comment-id-566" data-comment-index="0">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    What makes you think he was in Miami Beach, Demo Teacher?
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="567" id="comment-id-567" data-comment-index="1">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    I think he was in Miami Beach because his license plate was a Miami Beach license plate, ESI.
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/567/comments" data-comment-id="567">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="569" id="comment-id-569" data-comment-index="2">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    Ok, that makes sense Demo Teacher, thank you!
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/569/comments" data-comment-id="569">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" id="delete_discussion" data-discussion-id="104">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </div>
            </div>

        </div>
        <div class="panel panel-primary">

            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-3" aria-expanded="false" class="collapsed">
                    <h3 class="panel-title text-white"><i class="ti-write"></i> Question: Where was he born? <br />
                        <div class="question-author">
                            <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;"> <small>ESI 20 hours ago</small>
                        <span class="pull-right">
                            <i class="fa fa-fw panel-indicator ti-angle-up"></i>
                        </span>
                        </div>

                    </h3>
                </a>
            </div>

            <div id="columns-dev-3" class="panel-collapse collapse" aria-expanded="false" style="">
                <div class="panel-body" style="min-height:200px;">
                    <div class="well">
                        <label for="answers[157]" class="control-label">Your Reply</label>
                        <textarea name="answers[157]" title="Where was the man?" class="required is-popup"></textarea>
                        <br />

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success pull-left" id="submit_discussion_response">
                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                            </button>


                            <button type="button" class="btn btn-info" id="save_discussion_response_draft">
                                <span class="glyphicon glyphicon-hdd"></span> Save As Draft
                            </button>




                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> Cancel
                            </button>
                        </div>
                    </div>

                    <div class="alert-message alert-message-default">
                        <label class="control-label">2 Replies</label><hr />
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/174/destroy" data-answer-id="174">
                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                    <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami, FL.
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>

                            <!--<div class="alert alert-info alert-dismissable" style="margin: 0 18px;">
<strong> Heads up!</strong> There are no comments yet.
</div>-->

                            <div class="comments"></div>

                        </div>
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/180/destroy" data-answer-id="180">


                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                    <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami Beach!
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>



                            <div class="comments">
                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="566" id="comment-id-566" data-comment-index="0">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    What makes you think he was in Miami Beach, Demo Teacher?
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="567" id="comment-id-567" data-comment-index="1">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    I think he was in Miami Beach because his license plate was a Miami Beach license plate, ESI.
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/567/comments" data-comment-id="567">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="569" id="comment-id-569" data-comment-index="2">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    Ok, that makes sense Demo Teacher, thank you!
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/569/comments" data-comment-id="569">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" id="delete_discussion" data-discussion-id="104">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </div>
            </div>

        </div>
        <div class="panel panel-primary">

            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#columns-holder" href="#columns-dev-4" aria-expanded="false" class="collapsed">
                    <h3 class="panel-title text-white"><i class="ti-write"></i> Question: How much does he weigh? <br />
                        <div class="question-author">
                            <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;"> <small>ESI 20 hours ago</small>
                        <span class="pull-right">
                            <i class="fa fa-fw panel-indicator ti-angle-up"></i>
                        </span>
                        </div>

                    </h3>
                </a>
            </div>

            <div id="columns-dev-4" class="panel-collapse collapse" aria-expanded="false" style="">
                <div class="panel-body" style="min-height:200px;">
                    <div class="well">
                        <label for="answers[157]" class="control-label">Your Reply</label>
                        <textarea name="answers[157]" title="Where was the man?" class="required is-popup"></textarea>
                        <br />

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success pull-left" id="submit_discussion_response">
                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                            </button>


                            <button type="button" class="btn btn-info" id="save_discussion_response_draft">
                                <span class="glyphicon glyphicon-hdd"></span> Save As Draft
                            </button>




                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> Cancel
                            </button>
                        </div>
                    </div>

                    <div class="alert-message alert-message-default">
                        <label class="control-label">2 Replies</label><hr />
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/174/destroy" data-answer-id="174">
                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                    <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami, FL.
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>

                            <!--<div class="alert alert-info alert-dismissable" style="margin: 0 18px;">
<strong> Heads up!</strong> There are no comments yet.
</div>-->

                            <div class="comments"></div>

                        </div>
                        <div class="answer-container" data-delete-url="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/discussion/answer/180/destroy" data-answer-id="180">


                            <blockquote class="answer">
                                <div class="timeline-panel" style="display:inline-block;">
                                    <div class="timeline-heading">
                                        <p>
                                            <small class="text-default-gray"> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                    <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==" style="width:20px; height: 20px;">
                                                </a> <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a> 20 hours ago </small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                            He was in Miami Beach!
                                        </p>
                                    </div>

                                    <div class="timeline-footer">
                                        <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">

                                            <button class="btn btn-xs btn-action btn-success" id="open_answer_comment" data-answer-id="174">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Reply
                                            </button>
                                            <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </blockquote>



                            <div class="comments">
                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="566" id="comment-id-566" data-comment-index="0">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    What makes you think he was in Miami Beach, Demo Teacher?
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/566/comments" data-comment-id="566">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="567" id="comment-id-567" data-comment-index="1">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154">
                                                <img data-name="Demo Teacher" class="participant" alt="Demo Teacher" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="Demo Teacher" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkRUPC90ZXh0Pjwvc3ZnPg==">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/154" class="author"> Demo Teacher</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    I think he was in Miami Beach because his license plate was a Miami Beach license plate, ESI.
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/567/comments" data-comment-id="567">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                                <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="569" id="comment-id-569" data-comment-index="2">
                                    <li>
                                        <div class="timeline-badge center">
                                            <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1">
                                                <img data-name="ESI" class="participant" alt="ESI" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="ESI" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHBvaW50ZXItZXZlbnRzPSJub25lIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgc3R5bGU9ImJhY2tncm91bmQtY29sb3I6IHJnYigyMzAsIDEyNiwgMzQpOyB3aWR0aDogMTAwcHg7IGhlaWdodDogMTAwcHg7IGJvcmRlci1yYWRpdXM6IDBweDsiPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHk9IjUwJSIgeD0iNTAlIiBkeT0iMC4zNWVtIiBwb2ludGVyLWV2ZW50cz0iYXV0byIgZmlsbD0iI2ZmZmZmZiIgZm9udC1mYW1pbHk9Ik9wZW4gU2FucyxIZWx2ZXRpY2FOZXVlLUxpZ2h0LEhlbHZldGljYSBOZXVlIExpZ2h0LEhlbHZldGljYSBOZXVlLEhlbHZldGljYSwgQXJpYWwsTHVjaWRhIEdyYW5kZSwgc2Fucy1zZXJpZiIgc3R5bGU9ImZvbnQtd2VpZ2h0OiAzMDA7IGZvbnQtc2l6ZTogNjBweDsiPkU8L3RleHQ+PC9zdmc+">
                                            </a>
                                        </div>
                                        <div class="timeline-panel" style="display:inline-block;">
                                            <div class="timeline-heading">
                                                <p>
                                                    <small class="text-default-gray">20 hours ago <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/profile/1" class="author"> ESI</a></small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>
                                                    Ok, that makes sense Demo Teacher, thank you!
                                                </p>
                                            </div>

                                            <div class="timeline-footer">
                                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">



                                                    <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/api/video-center/569/comments" data-comment-id="569">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" id="delete_discussion" data-discussion-id="104">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </div>
            </div>

        </div>

</div>
</div>
</form>
</div>
<!-- / END OSI EDIT HERE -->

<script src="{{ app('request')->root() }}/js/custom_js/form_wizards.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/custom_js/calendar_custom.js" type="text/javascript"></script>
@endsection