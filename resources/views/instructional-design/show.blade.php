@extends('layouts.default')

@section('content')

    @include('instructional-design.popups')

    <section class="instructional-design component">

        {{--@include('instructional-design.top')--}}
        <div class="row normalize-row">
            <div class="col-md-12">
                <div class="btn-group pull-right" role="group" aria-label="Video actions">
                    @if ($lessonPlan->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin'))
                        <button class="icon-edit btn btn-info" type="button" title="Edit Post" data-trigger="edit-post">Edit Post</button>

                        @if ($user->is('mod') or $user->is('super_admin'))
                            <button class="icon-remove btn btn-danger" type="button" title="Remove Post" data-trigger="remove-post">Remove Post</button>
                        @else
                            <button class="icon-remove btn btn-danger" type="button" title="Request to Remove" data-trigger="request-to-remove">Request to Remove</button>
                        @endif
                    @endif

                            <a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>
                            <a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel">
                <div class="panel-heading" style="overflow: auto;">
                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                        {{ $lessonPlan->title }}
                    </h3>
                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                        <div class="row">
                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                <div class="img">
                                    <span class="profile-pic"><img src="{{ $lessonPlan->author->avatar->url() }}" alt="{{ $lessonPlan->author->name }}"></span>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="details">
                                    <div class="name">
                                        <small>{{ $lessonPlan->author->displayName }}</small>
                                    </div>
                                    <div class="time">
                                        <i class="ti-time"></i>
                                        <span data-class="date-time">
                                            {{ $lessonPlan->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($lessonPlan->lastContributor))
                        <div class="col-md-6 col-lg-6 col-sm-6 bord">
                            <p class="pull-right"><i class="icon icon-clock"></i> Last updated by {{ $lessonPlan->lastContributor->display_name }} <strong>{{ $lessonPlan->updated_at->diffForHumans() }}</strong></p>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="col-md-12 bord">
                        <div class="row">
                            <div class="col-md-8">

                                @if( !empty($lessonPlan->description) )
                                <div class="alert-message alert-message-default">{!! $lessonPlan->description !!}</div>
                                @endif


                                @if(count($lessonPlanDocument) > 0 or count($answers) > 0)
                                            <div class="panel-group" id="outline-holder">

                                                <div class="panel panel-primary panel-faq">
                                                    <div class="panel-heading">
                                                        <a data-toggle="collapse" data-parent="#outline-holder" href="#outline-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">
                                                            <h4 class="panel-title text-white">
                                                                <i class="ti-blackboard"></i> Lesson Plan
                                                                <span class="pull-right"></span>
                                                                <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up panel-indicator"></i>
                                </span>
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div id="outline-{{ $lessonPlan->id }}" class="panel-collapse collapse in" aria-expanded="false">
                                                        <div class="panel-body">

                                                            <div class="tab-pane fade active in" id="outline-{{ $lessonPlan->id }}">



                                                                        @if(count($lessonPlanDocument) > 0)
                                                                            <div class="well well-sm">
                                                                            <a href="{{ $lessonPlanDocument->path }}" target="_blank" data-target="{{ $lessonPlanDocument->id }}" class="btn btn-primary btn-xs" title="Download Lesson Plan"><i class="fa fa-file-@if ($lessonPlanDocument->extension == 'docm' || $lessonPlanDocument->extension == 'docx' || $lessonPlanDocument->extension == 'doc')word-o @elseif  ($lessonPlanDocument->extension == 'pdf')pdf-o @elseif  ($lessonPlanDocument->extension == 'jpeg' || $lessonPlanDocument->extension == 'jpg' || $lessonPlanDocument->extension == 'gif' || $lessonPlanDocument->extension == 'tiff' || $lessonPlanDocument->extension == 'png')image-o @elseif  ($lessonPlanDocument->extension == 'xls' || $lessonPlanDocument->extension == 'xlsx')excel-o @endif

                                                                                            icon-fw"></i> Download Lesson Plan
                                                                            </a>
                                                                                <div style="margin-top: 12px;">
                                                                                    {{--<embed data="{{ $lessonPlanDocument->path }}" type="application/@if ($lessonPlanDocument->extension == 'docm' || $lessonPlanDocument->extension == 'docx' || $lessonPlanDocument->extension == 'doc')word @elseif  ($lessonPlanDocument->extension == 'pdf')pdf @elseif  ($lessonPlanDocument->extension == 'jpeg' || $lessonPlanDocument->extension == 'jpg' || $lessonPlanDocument->extension == 'gif' || $lessonPlanDocument->extension == 'tiff' || $lessonPlanDocument->extension == 'png')image @elseif  ($lessonPlanDocument->extension == 'xls' || $lessonPlanDocument->extension == 'xlsx')excel @endif" width="300" height="200" src="{{ $lessonPlanDocument->path }}" />--}}
                                                                                    <iframe src="http://docs.google.com/gview?url=http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com{{ $lessonPlanDocument->path }}&embedded=true" style="width: 100%; height: 575px;" frameborder="0"></iframe>

                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if(count($answers))
                                                                            <div class="well well-sm">
                                                                                <div class="ui-group-buttons">
                                                                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#lessonPlanTemplate"><i class="ti-bookmark-alt"></i> View Lesson Plan</button>

                                                                                    <div id="lessonPlanTemplate" class="modal fade animated" role="dialog">
                                                                                        <div class="modal-dialog modal-lg">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                                                                    <h4 class="modal-title">Lesson Plan Template</h4>
                                                                                                </div>
                                                                                                <div class="modal-body" style="overflow:auto;">
                                                                                                    @include('forms.lesson-plan')
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif


                                                                                <!-- This should be the first thing the Author sees. Here they choose if they fill out the form or upload a lesson plan -->
                                                                                @if ($lessonPlan->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin'))
                                                                                    @if(count($lessonPlanDocument) == 0 or count($answers) == 0 or $lessonPlan->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin'))
                                                                                        <div class="alert-message alert-message-info">
                                                                                            <small style="text-transform: uppercase;"><i class="ti-blackboard"></i> Edit Lesson Plan</small><br />
                                                                                            <div class="ui-group-buttons">
                                                                                                <button type="button" class="btn btn-success btn-xs" data-trigger="new-lesson-plan-document"><i class="ti-upload"></i> Upload</button>
                                                                                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#lessonPlanTemplate" style="border-bottom-right-radius: 3px; border-top-right-radius: 3px;"><i class="ti-bookmark-alt"></i>
                                                                                                    Use Template
                                                                                                </button>

                                                                                                <div id="lessonPlanTemplate" class="modal fade animated" role="dialog">
                                                                                                    <div class="modal-dialog modal-lg">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                                                                                                <h4 class="modal-title">Lesson Plan Template</h4>
                                                                                                            </div>
                                                                                                            <div class="modal-body" style="overflow:auto;">
                                                                                                                @include('forms.lesson-plan')
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        @endif
                                                                                        @endif
                                                                                                <!-- Lesson Plan Outline -->


                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>




                                        {{--<div class="panel-group" id="outline-holder">--}}
                                            {{--<div class="panel panel-info panel-faq">--}}
                                            {{--<div class="panel-heading">--}}
                                                {{--<a data-toggle="collapse" data-parent="#outline-holder" href="#outline-{{ $lessonPlan->id }}" class="collapsed in" aria-expanded="false">--}}
                                                    {{--<h4 class="panel-title text-white">--}}
                                                        {{--<i class="ti-blackboard"></i> Lesson Plan--}}
                                                        {{--<span class="pull-right"></span>--}}
                                                    {{--</h4>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}

                                            {{--<div id="outline-{{ $lessonPlan->id }}" class="panel-body panel-collapse collapse in" aria-expanded="false">--}}
                                                    {{--<div class="well">--}}
                                                        {{--@if(count($lessonPlanDocument) > 0)--}}
                                                            {{--<a href="{{ $lessonPlanDocument->path }}" target="_blank" data-target="{{ $lessonPlanDocument->id }}"><button class="btn btn-info" type="button" title="Download Lesson Plan"><i class="icon icon-@if ($lessonPlanDocument->extension == 'docm' || $lessonPlanDocument->extension == 'docx' || $lessonPlanDocument->extension == 'doc')word @elseif  ($lessonPlanDocument->extension == 'pdf')pdf @elseif  ($lessonPlanDocument->extension == 'jpeg' || $lessonPlanDocument->extension == 'jpg' || $lessonPlanDocument->extension == 'gif' || $lessonPlanDocument->extension == 'tiff' || $lessonPlanDocument->extension == 'png')image @elseif  ($lessonPlanDocument->extension == 'xls' || $lessonPlanDocument->extension == 'xlsx')excel @endif--}}

                                                                            {{--icon-fw"></i> Download Lesson Plan</button>--}}
                                                            {{--</a>--}}
                                                        {{--@endif--}}

                                                        {{--@if(count($answers))--}}
                                                            {{--<div class="well well-sm">--}}
                                                                {{--<div class="ui-group-buttons">--}}
                                                                    {{--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#lessonPlanTemplate"><i class="ti-bookmark-alt"></i> View Lesson Plan</button>--}}

                                                                    {{--<div id="lessonPlanTemplate" class="modal fade animated" role="dialog">--}}
                                                                        {{--<div class="modal-dialog modal-lg">--}}
                                                                            {{--<div class="modal-content">--}}
                                                                                {{--<div class="modal-header">--}}
                                                                                    {{--<button type="button" class="close" data-dismiss="modal">×</button>--}}
                                                                                    {{--<h4 class="modal-title">Lesson Plan Template</h4>--}}
                                                                                {{--</div>--}}
                                                                                {{--<div class="modal-body" style="overflow:auto;">--}}
                                                                                    {{--@include('forms.lesson-plan')--}}
                                                                                {{--</div>--}}
                                                                            {{--</div>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--@endif--}}
                                                        {{----}}
                                                    {{--</div>--}}


                                            {{--</div>--}}

                                        {{--</div>--}}
                                        {{--</div>--}}


                                @endif

                                        @if($lessonPlan->participants->count()>0 or $lessonPlan->tags->count()>0 )
                                            @if($lessonPlan->participants->count()>0)
                                                <div class="well well-sm">
                                                    <small><strong>PARTICIPANTS</strong></small>

                                                    @foreach ($lessonPlan->participants as $participant)

                                                        <a href="{{ route('profile', ['id' => $participant->id ]) }}" title="{{ $participant->displayName }}"><img data-name="{{ $participant->displayName }}" class="participant" alt="{{ $participant->displayName }}" /></a>

                                                    @endforeach

                                                </div>
                                            @endif
                                            @if($lessonPlan->tags->count()>0)

                                                <div class="well well-sm">
                                                    <small><strong>TAGS</strong></small>
                                                    @foreach($lessonPlan->tags as $tag)

                                                        <a href="{{route('video-center.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-xs btn-primary tag">
                                                            <small>{{$tag->tag}}</small>
                                                        </a>

                                                    @endforeach

                                                </div>
                                                @endif
                                                @endif

                                <!-- / Lesson Plan Outline -->
                            </div>
                            <div class="col-md-4">
                                {{--<div class="panel-group" id="description-holder">--}}

                                    {{--<div class="panel panel-primary panel-faq">--}}
                                        {{--<div class="panel-heading">--}}
                                            {{--<a data-toggle="collapse" data-parent="#description-holder" href="#description-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">--}}
                                                {{--<h4 class="panel-title text-white">--}}
                                                    {{--<i class="ti-marker-alt"></i> Description--}}
                                                    {{--<span class="pull-right"></span>--}}
                                                {{--</h4>--}}
                                            {{--</a>--}}
                                        {{--</div>--}}
                                        {{--<div id="description-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">--}}
                                            {{--<div class="panel-body">--}}

                                                {{--<div class="tab-pane fade active in" id="description-{{ $lessonPlan->id }}">--}}
                                                    {{--<div class="well">--}}

                                                        {{--<p class="description">{!! $lessonPlan->description !!}</p>--}}

                                                    {{--</div>--}}
                                                {{--</div>--}}

                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                @include('partials.exemplar_features')

                                <div class="panel-group" id="documents-holder">

                                    <div class="panel panel-primary panel-faq">
                                        <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#documents-holder" href="#documents-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">
                                                <h4 class="panel-title text-white">
                                                    <i class="ti-agenda"></i> Supporting Documents
                                                    <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                </span>
                                                </h4>
                                            </a>
                                        </div>
                                        <div id="documents-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">

                                                <div class="tab-pane fade active in" id="documents-{{ $lessonPlan->id }}">
                                                    <div class="well well-sm">

                                                        @include('partials.supporting-documents', ['docs' => $documents])

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--@if($lessonPlan->participants->count()>0 or $lessonPlan->tags->count()>0 )--}}

                                    {{--<div class="panel-group" id="accordion-cat-1">--}}
                                        {{--@if($lessonPlan->participants->count()>0)--}}
                                            {{--<div class="panel panel-primary panel-faq">--}}
                                                {{--<div class="panel-heading">--}}
                                                    {{--<a data-toggle="collapse" data-parent="#accordion-cat-1" href="#ppl-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">--}}
                                                        {{--<h4 class="panel-title text-white">--}}
                                                            {{--<i class="ti-user"></i> Participants--}}
                                                            {{--<span class="pull-right"></span>--}}
                                                        {{--</h4>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                                {{--<div id="ppl-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">--}}
                                                    {{--<div class="panel-body">--}}

                                                        {{--<div class="tab-pane fade active in" id="ppl">--}}
                                                            {{--<div class="well">--}}

                                                                {{--@foreach ($lessonPlan->participants as $participant)--}}

                                                                    {{--<button type="button" class="btn btn-labeled btn-default participant" style="margin-bottom: 5px;margin-right: 5px;">--}}
                                                {{--<span class="btn-label">--}}
                                                 {{--<img src="{{ $participant->avatar->url() }}" alt="{{ $participant->displayName }}" title="{{ $participant->displayName }}" style="width: 30px;">--}}
                                            {{--</span> <small>{{ $participant->displayName }}</small>--}}
                                                                    {{--</button>--}}

                                                                {{--@endforeach--}}

                                                            {{--</div>--}}
                                                        {{--</div>--}}

                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                        {{--@if($lessonPlan->tags->count()>0)--}}
                                            {{--<div class="panel panel-primary panel-faq">--}}
                                                {{--<div class="panel-heading">--}}
                                                    {{--<a data-toggle="collapse" data-parent="#accordion-cat-1" href="#tags-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">--}}
                                                        {{--<h4 class="panel-title text-white">--}}
                                                            {{--<i class="ti-tag"></i> Tags--}}
                                                            {{--<span class="pull-right"></span>--}}
                                                        {{--</h4>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                                {{--<div id="tags-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">--}}
                                                    {{--<div class="panel-body">--}}
                                                        {{--<div class="well">--}}

                                                            {{--@foreach($lessonPlan->tags as $tag)--}}

                                                                {{--<a href="{{route('instructional-design.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">--}}
                                                                    {{--<small>{{$tag->tag}}</small>--}}
                                                                {{--</a>--}}

                                                            {{--@endforeach--}}

                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                {{--@endif--}}

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    <!-- Comments -->
    <div class="row video-details normalize-row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#comments-holder" href="#comments-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">
                        <h3 class="panel-title text-white"><i class="ti-comment-alt"></i> Comments
                            <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                        </h3>
                    </a>
                </div>
                <div id="comments-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    @if ( count($comments) > 0 )
                        <i class="icon icon-triangle-up comments-triangle"></i>
                        <div class="comments full">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>Submitted</th>
                                        @if ($user->is('super_admin') or $user->is('mod'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                            @foreach ($comments as $comment)
                                <tr data-comment-id="{{ $comment->id }}" id="comment-id-{{ $comment->id }}">
                                    <td><a href="{{ route('profile', ['id' => $comment->author->id ]) }}">
                                        <span class="profile-pic">
                                            <img src="{{ $comment->author->avatar->url() }}" alt="{{ $comment->author->display_name }}"></span> {{ $comment->author->display_name }}</a></td>
                                    <td>{{ $comment->comment_date }}</td>
                                    <td>{!! $comment->content !!}</td>
                                    <td>{{ $comment->updated_at->diffForHumans() }}</td>
                                    @if ($user->is('super_admin') or $user->is('mod'))
                                        <td>
                                            <div class="comment-actions">
                                                <button type="button" class="btn btn-action btn-danger delete-comment" data-route="{{ route('api.video-center.comments.destroy', ['id' => $comment->id]) }}" data-comment-id="{{ $comment->id }}">Delete Comment</button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="add-comment full">
                        <form method="POST" action="{{ route('api.instructional-design.comments-activity.store', ['id' => $lessonPlan->id]) }}" class="comment-form">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <div class="col-md-1">
                                    <div class="profile-pic"><img src="{{ $user->avatar->url() }}" alt="{{ $user->display_name }}"></div>
                                </div>
                                <div class="col-md-11">
                                    <textarea rows="4" class="form-control resize_vertical" name="content" placeholder="Add a comment..."></textarea>
                                    <br />
                                    <input type="date" class="form-control" name="comment_date" placeholder="Comment Date" />
                                </div>
                            </div>
                            <input type="hidden" name="type" value="{{ $user->type }}">
                            <div class="form-group">
                                <div class="col-md-1"></div>
                                <div class="col-md-11" style="margin-top: 10px;">
                                    <button type="submit" class="btn btn-comment btn-success">Record Activity</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- / Comments -->

    @if ($user->isEither(['master_teacher', 'super_admin', 'project_admin']))
        <!-- / Admin Comments -->
        <div class="row video-details normalize-row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#adminComments-holder" href="#adminComments-{{ $lessonPlan->id }}" class="collapsed" aria-expanded="false">
                            <h3 class="panel-title text-white"><i class="ti-comments"></i> Admin Comments
                            <span class="pull-right">
                                <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                            </span>
                            </h3>
                        </a>
                    </div>
                    <div id="adminComments-{{ $lessonPlan->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        @include('comments_list', [
                            'comments' => $lessonPlan->adminComments
                        ])

                        <div class="add-comment full">
                            @include('forms/new-comment', [
                                'author' => $lessonPlan->author,
                                'message' => $lessonPlan,
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
<script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/js//custom_js/datatables_custom.js"></script>

@endsection
