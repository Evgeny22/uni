@foreach ($videos as $video)
    @if($video->author)
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12 bord">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="img video-container">
                                <a href="{{ $video->url }}" class="linkwrap">
                                    <div class="wistia_thumbnail_container">
                                        <span class="play"></span>
                                        <div class="duration">
                                            <span>{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i></span>
                                        </div>
                                        <img class="wistia-thumbnail" data-wistia-hashed-id="{{ $video->wistia_hashed_id }}" data-video-id="{{ $video->id }}" src="">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel">
                                <div class="panel-heading" style="overflow: auto;">
                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                        <a href="{{ $video->url }}">{{ $video->title }}</a>
                                    </h3>
                                    <div class="col-md-12 bord">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                                            <div class="col-md-2" style="margin-left:-15px; margin-right: -25px;">
                                                <div class="img">
                                                    <a href="{{ route('profile', ['id' => $video->author->id ]) }}"><span class="profile-pic"><img src="{{ $video->author->avatar->url() }}" alt="{{ $video->author->name }}"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="details">
                                                    <div class="name">
                                                        <small>
                                                            <a href="{{ route('profile', ['id' => $video->author->id ]) }}">
                                                                {{ $video->author->displayName }}
                                                            </a>
                                                        </small>
                                                    </div>
                                                    <div class="time">
                                                        <small><i class="ti-time"></i>
                                                            <span class="date-time">{{ $video->created_at->format('m/d/y') }}</span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="col-md-12" style="margin-left:-15px;"> <small><strong>DURATION</strong></small></div>--}}
                                            {{--<div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">--}}
                                                {{--{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i>--}}
                                            {{--</div>--}}
                                        </div>
                                        @if( !empty($video->description) )
                                        <div class="row description-row">
                                            <div class="col-md-12" style="margin-left:-15px;">
                                                {{--<small><strong>DESCRIPTION</strong></small><br />--}}
                                                {!! $video->description !!}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row description-row">
                                            <div class="col-md-12" style="margin-left:-15px;">
                                                <small><strong>DURATION</strong></small>
                                                <p>{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i></p>
                                            </div>
                                        </div>
                                        <div class="duration">

                                        </div>
                                    </div>
                                    {{--<span class="btn-label label-right btn-success pull-right">
                                                            <span class="text-white">{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i></span>
                                                        </span>--}}
                                </div>
                                </div>

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

                                    <div class="well well-sm">
                                        <small><strong>TAGS</strong></small>
                                        @foreach($video->tags as $tag)

                                            <a href="{{ route('video-center.index')."/search?search=1&search_tags[]=". $tag->id }}" class="btn btn-xs btn-primary tag">
                                                <small>{{$tag->tag}}</small>
                                            </a>

                                        @endforeach

                                    </div>
                                @endif
                            @endif
                            <div class="btn-group" role="group" aria-label="Video actions">
                                <a class="btn btn-success btn-sm" href="{{ $video->url }}">Open</a>
                                {{--<a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>--}}
                                {{--<a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {{--<span class="exemplar">

                    @if ($video->isExemplar == true)

                                                <i class="icon icon-exemplar" title="This video is marked as exemplar"></i>

                                            @else

                                                &nbsp;

                                            @endif

                        </span>
                <span class="post-modifications">
                        @if ($video->isAuthoredBy($user) or $user->is('super_admin') or $user->is('mod'))
                        <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                        <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                    @endif
                        </span>--}}
            </div>

        </div>

    @endif

@endforeach