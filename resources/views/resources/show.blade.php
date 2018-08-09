@extends('layouts.default')

@section('content')

@include('resources.popups')

<section class="resources component">
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
                            <a class="btamv" type="" href="{{ route ('resources') }}"><< Back to All Resources</a>

                            @if ($resource->is_private == '1' and $resource->isAuthoredBy($user))
                            <button class="btn btn-success btn-sm share-object" href="#" data-toggle="modal" data-target="#shareObjectModal" data-object-id="{{ $resource->id }}" data-object-type="{{ get_class($resource) }}">Share Resource</button>
                            @endif

                            @if ($user->is('super_admin') or $user->is('mod') or ($resource->isAuthoredBy($user) and $user->is('coach') or $user->is('master_teacher')) or ($resource->isAuthoredBy($user)))
                                @if ($resource->is_private == '1')
                                    <a class="btn btn-success btn-sm" href="{{ route('resources.make-public', ['id' => $resource->id]) }}">Make Public</a>
                                @endif
                            @endif

                            @if($isSaved)
                                <button class="btn btn-success btn-sm unsave-object" href="#" data-object-id="{{ $resource->id }}" data-object-type="{{ get_class($resource) }}">Unbookmark Resource</button>
                            @else
                                <button class="btn btn-success btn-sm save-object" href="#" data-object-id="{{ $resource->id }}" data-object-type="{{ get_class($resource) }}">Bookmark Resource</button>
                            @endif

                            {{--@if ($user->isEither(['master_teacher', 'super_admin', 'project_admin']))
                                @if ($resource->isExemplar && $resource->exemplar()->approved == true)
                                    <button class="btn btn-success btn-sm" data-trigger="exemplar-remove">Remove as Resource</button>
                                @else
                                    <button class="btn btn-success btn-sm" data-trigger="exemplar-request">Make a Resource</button>
                                @endif
                            @endif--}}

                            @if ($resource->is_private == '1')
                                <button class="btn btn-success btn-sm resource-make" data-resource-id="{{ $resource->id }}">Make a Resource</button>
                            @endif

                            @if ($user->is('super_admin') or $user->is('mod') or ($resource->isAuthoredBy($user) and $user->is('coach') or $user->is('master_teacher')) or ($resource->isAuthoredBy($user)))
                                <button class="icon-edit btn btn-warning btn-sm" type="button" title="Edit Post" data-trigger="edit-post">Edit Resource Post</button>
                                <button class="icon-remove btn btn-danger btn-sm" type="button" title="Remove Post" data-trigger="remove-post">Delete Resource</button>
                            @endif
                            {{--@endif--}}
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
                    {{ $resource->title }}
                </h3>
                <div class="col-md-6 col-lg-6 col-sm-6 bord">
                    <div class="row">
                        <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                        <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                            <div class="img">
                                <span class="profile-pic"><img src="{{ $resource->author->avatar->url() }}" alt="{{ $resource->author->name }}"></span>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="details">
                                <div class="name">
                                    <small>{{ $resource->author->displayName }}</small>
                                </div>
                                <div class="time">
                                    <small>
                                        <i class="ti-time"></i>
                                        <span data-class="date-time">{{ $resource->created_at->format('m/d/y') }}</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <div class="col-md-12 bord">
                    <div class="row">
                        <div class="col-md-12">
                            @if($resource->tags->count()>0 )
                                <div class="well well-sm">
                                    <small><strong>TAGS</strong></small>
                                    @foreach($resource->tags as $tag)
                                        <a href="{{route('video-center.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-xs btn-primary tag">
                                            <small>{{$tag->tag}}</small>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                            <div class="col-sm-8">
                                <article class="module" style="float:none; margin-bottom: 12px; padding:5px;">
                                    <div class="module-content pad-narrow">
                                        {!! $resource->description !!}
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-4">
                                @if ($resource->document_path() != '')
                                <a href="{{$resource->document_path()}}" target="_blank" class="btn btn-primary btn-inline pull-right document-url" data-name="{{$resource->documents->first()->title}}">Download Resource Document</a>
                                @else
                                    <a href="{{$resource->remote_url}}" target="_blank" class="btn btn-primary btn-inline pull-right document-url" data-name="{{$resource->remote_url}}">Open Resource Document</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row video-details normalize-row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#comments-holder" href="#comments-{{ $resource->id }}" class="collapsed" aria-expanded="false">
                        <h3 class="panel-title text-white"><i class="ti-comments"></i> Comments
                            <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-down panel-indicator"></i>
                                </span>
                        </h3>
                    </a>
                </div>
                @if ($resource->comments->count() == 0)
                    <div id="comments-{{ $resource->id }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    </div>
                @else
                    <div id="comments-{{ $resource->id }}" class="panel-collapse collapse in" aria-expanded="true">
                        @endif

                        <div class="panel-body">
                            @include('comments_list', [
                                'comments' => $resource->comments,
                                'can_reply' => true
                            ])

                            <div class="add-comment full">
                                @include('forms/new-comment', [
                                    'author' => $resource->author,
                                    'message' => $resource,
                                ])
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection