@foreach ($resources as $resource)
    <div class="panel">
        <div class="panel-body">
            <div class="col-md-12 bord">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading" style="overflow: auto;">
                                <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                    <a href="{{ route('resources.show', ['id' => $resource->id]) }}">{{ $resource->title }}</a>
                                </h3>
                                <div class="col-md-6 col-lg-6 col-sm-6 bord">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-left:-15px;"> <small><strong>AUTHOR</strong></small></div>
                                        <div class="col-md-2" style="margin-left:-15px;">
                                            <div class="img">
                                                <a href="{{ route('profile', ['id' => $resource->author->id ]) }}"><span class="profile-pic"><img src="{{ $resource->author->avatar->url() }}" alt="{{ $resource->author->name }}"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="details">
                                                <div class="name">
                                                    <small>
                                                        <a href="{{ route('profile', ['id' => $resource->author->id ]) }}">
                                                            {{ $resource->author->displayName }}
                                                        </a>
                                                    </small>
                                                </div>
                                                <div class="time">
                                                    <small><i class="ti-time"></i>
                                                        <span class="date-time">{{ $resource->created_at->format('m/d/y') }}</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-12" style="margin-left:-15px;"> <small><strong>DURATION</strong></small></div>--}}
                                        {{--<div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">--}}
                                        {{--{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i>--}}
                                        {{--</div>--}}
                                    </div>
                                    @if( !empty($resource->description) )
                                        <div class="row description-row">
                                            <div class="col-md-12" style="margin-left:-15px;">
                                                <small><strong>DESCRIPTION</strong></small>
                                                {{ str_limit($resource->description, 100, '...') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{--<span class="btn-label label-right btn-success pull-right">
                                                        <span class="text-white">{{ date('i:s', $video->wistia_duration) }} <i class="ti-timer"></i></span>
                                                    </span>--}}
                            </div>
                        </div>

                        @if($resource->tags->count()>0)
                            <div class="well well-sm">
                                <small><strong>TAGS</strong></small>
                                @foreach($resource->tags as $tag)

                                    <a href="{{route('resources.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-xs btn-primary tag">
                                        <small>{{$tag->tag}}</small>
                                    </a>

                                @endforeach

                            </div>
                        @endif

                        <div class="btn-group" role="group" aria-label="Resource actions">
                            <a class="btn btn-success btn-sm" href="{{ route('resources.show', ['id' => $resource->id]) }}">Open</a>
                            {{--<a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>--}}
                            {{--<a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach