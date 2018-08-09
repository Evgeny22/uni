@extends('layouts.default')

@section('content')

@include('messages.popups')

{{--<section class="message-board component message-detail">--}}

    {{--@include('messages.top')--}}

    {{--<div class="row">--}}

        {{--<article class="module">--}}

            {{--<h2 class="secondary-bg">Message Board</h2>--}}

            {{--<div class="module-content pad-wide">--}}

                {{--@include('partials.message', [--}}
                  {{--'message' => $message,--}}
                {{--])--}}

            {{--</div>--}}

        {{--</article>--}}

    {{--</div>--}}

{{--</section>--}}

<section class="message-board component message-detail">

    <div class="row">
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

                            <a class="btamv" type="button" href="{{ route('messages.index') }}"><< Back to All Messages</a>
                            @if($message->comments->count()==0 )
                                @if (($message->isAuthoredBy($user) or $user->is('mod') or $user->is('super_admin')) and $message->comments->count() == 0)
                                <button class="icon-edit btn btn-info btn-sm" type="button" title="Edit Post" data-trigger="edit-post">Edit Message</button>
                                @endif
                            @endif

                            @if ($user->is('mod') or $user->is('super_admin'))
                                <button class="icon-remove btn btn-danger btn-sm" type="button" title="Remove Post" data-trigger="remove-post">Delete Message</button>
                            @else
                                @if ($requestedDelete)
                                    <button class="icon-remove btn btn-danger btn-sm" type="button" title="Request to Delete" disabled="disabled">Requested to Delete</button>
                                @elseif (($message->isAuthoredBy($user)))
                                    <button class="icon-remove btn btn-danger request-delete btn-sm" data-object-id="{{ $message->id }}" data-object-type="{{ get_class($message) }}" type="button" title="Request to Delete">Request to Delete</button>
                                @endif
                            @endif

                            @if($isSaved)
                                <button class="btn btn-warning unsave-object btn-sm" href="#" data-object-id="{{ $message->id }}" data-object-type="{{ get_class($message) }}">Unsave Message</button>
                            @else
                                <button class="btn btn-warning save-object btn-sm" href="#" data-object-id="{{ $message->id }}" data-object-type="{{ get_class($message) }}">Save Message</button>
                            @endif

                            @if ($user->is('mod') or $user->is('super_admin') or $user->is('coach') or $user->is('master_teacher') or $user->is('teacher'))
                                <a href="{{ route('messages.export', ['id' => $message->id ]) }}">
                                    <button class="btn btn-warning btn-sm">Export Conversation</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading" style="overflow: auto;">
            <div class="col-md-12 bord">
                <div class="row">
                    <div class="col-md-1" style="margin-right:-35px;">
                        <div class="img">
                            <a href="{{ route('profile', ['id' => $message->author->id ]) }}"><span class="profile-pic"><img src="{{ $message->author->avatar->url() }}" alt="{{ $message->author->name }}"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="details">
                            <h4 class="panel-title" style="font-size: 18px;">
                                <a href="{{ $message->url }}">{{ $message->title }}</a>
                            </h4>
                            <div class="name">
                                <small><a href="{{ route('profile', ['id' => $message->author->id ]) }}">{{ $message->author->displayName }}</a> <span data-class="date-time">{{ $message->created_at->format("M d Y") }} at {{ $message->created_at->format("g:i A") }}</span></small>
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

                        @if( !empty($message->content) )
                            <div class="alert-message alert-message-default" style="padding: 10px;">
                                <p class="description">{!! $message->content !!}</p>
                            </div>
                            <a class="btn btn-success btn-sm" href="{{ $message->url }}#reply">Reply</a>
                        @endif

                        {{--@if($message->tags->count()>0)--}}
                            {{--<div class="well well-sm">--}}
                                {{--<small><strong>TAGS</strong></small>--}}
                                {{--@foreach($message->tags as $tag)--}}
                                    {{--<a href="#"><small>{{$tag->tag}}</small></a>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                        {{--@endif--}}

                        {{--@if($message->comments->count()>0 )--}}
                            <hr />
                            @if($message->participants->count()>0)
                            <div class="well well-sm" style="margin: 20px 0 10px!important;">
                                <small><strong>RECIPIENTS</strong></small><br />

                                @foreach ($message->participants as $participant)

                                    <a href="{{ route('profile', ['id' => $participant->id ]) }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="{{ $participant->displayName }}" class="participant"><span class="profile-pic small-pic"><img src="{{ $participant->avatar->url() }}" alt="{{ $participant->displayName }}"></span></a>

                                @endforeach

                            </div>
                            <hr />
                            @endif
                            <div id="comments-wrapper" @if($message->comments->count()==0 )style="display: none;" @else style="display: block;"@endif>
                                <div style="margin: 20px auto 10px; padding: 0 15px;">
                                    <small><strong>REPLIES</strong></small>
                                </div>
                                @include('comments_list', ['comments' => $message->comments])
                            </div>
                        {{--@endif--}}

                        <div id="reply" class="well message-reply well-sm" style="overflow: auto; margin-top: 10px;">
                            <div style="margin: 10px auto;">
                                <small><strong>LEAVE A REPLY</strong></small>
                            </div>
                            <div class="add-comment full">
                                @include('forms/new-comment', [
                                'author' => $message->author,
                                'message' => $message
                                ])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
