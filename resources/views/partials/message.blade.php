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
                    @endif
                    @if($message->participants->count()>0 )
                        @if($message->participants->count()>0)
                            <div class="well well-sm">
                                <small><strong>RECIPIENTS</strong></small><br />

                                @foreach ($message->participants as $participant)

                                    <a href="{{ route('profile', ['id' => $participant->id ]) }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="{{ $participant->displayName }}" class="participant"><span class="profile-pic small-pic"><img src="{{ $participant->avatar->url() }}" alt="{{ $participant->displayName }}"></span></a>

                                @endforeach

                            </div>
                        @endif
                        {{--@if($message->tags->count()>0)--}}

                        {{--<div class="well well-sm">--}}
                        {{--<small><strong>TAGS</strong></small>--}}
                        {{--@foreach($message->tags as $tag)--}}

                        {{--<a href="{{route('video-center.index')."/?search=1&tags=".str_replace(" ","+",$tag->id)}}" class="btn btn-xs btn-primary tag">--}}
                        {{--<small>{{$tag->tag}}</small>--}}
                        {{--</a>--}}

                        {{--@endforeach--}}

                        {{--</div>--}}
                        {{--@endif--}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="btn-group" role="group" aria-label="Video actions">
            <a class="btn btn-success btn-sm" href="{{ $message->url }}">Open</a>
            {{--<a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>--}}
            {{--<a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>--}}
        </div>
        <span class="exemplar">

        @if ($message->isExemplar == true)
                            <i class="icon icon-exemplar" title="This message is marked as exemplar"></i>
                        @endif
                        </span>
        <span class="post-modifications">
        @if ($message->isAuthoredBy($user) or $user->is('super_admin') or $user->is('mod'))
        <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
        <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                    @endif
                        </span>
    </div>

</div>