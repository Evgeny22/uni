<div class="panel">
    <div class="panel-heading" style="overflow: auto;">
        <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
            <a href="{{ $lessonPlan->url }}">{{ $lessonPlan->title }}</a>
        </h3>
        <div class="col-md-6 col-lg-6 col-sm-6 bord">
            <div class="row">
                <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                    <div class="img">
                        <a href="{{ route('profile', ['id' => $lessonPlan->author->id ]) }}"><span class="profile-pic"><img src="{{ $lessonPlan->author->avatar->url() }}" alt="{{ $lessonPlan->author->name }}"></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="details">
                        <div class="name">
                            <small><a href="{{ route('profile', ['id' => $lessonPlan->author->id ]) }}">{{ $lessonPlan->author->displayName }}</a></small>
                        </div>
                        <div class="time">
                            </small><i class="ti-time"></i> <span data-class="date-time">

                        {{ $lessonPlan->created_at->diffForHumans() }}

                    </span></small>
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
                    @if( !empty($lessonPlan->description) )
                    <div class="alert-message alert-message-default">{!! str_limit(strip_tags($lessonPlan->description), $limit = 500, $end = '...') !!}</div>
                    @endif
                    <div class="btn-group" role="group" aria-label="Video actions">
                        <a class="btn btn-success" href="{{ $lessonPlan->url }}"><i class="ti-blackboard"></i> Open</a>
                        {{--<a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>--}}
                        {{--<a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
                                        <span class="exemplar">

                            @if ($lessonPlan->isExemplar == true)

                                                <i class="icon icon-exemplar" title="This Instructional Design is marked as Exemplar"></i>

                                            @else

                                                &nbsp;

                                            @endif

                        </span>
                                        <span class="post-modifications">
                        @if ($lessonPlan->isAuthoredBy($user) or $user->is('super_admin') or $user->is('mod'))

                                                <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                                                <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                                            @endif
                        </span>



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

                                        {{--<a href="{{route('video-center.index')."/?search=true&tags=".str_replace(" ","+",$tag->tag)}}" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">--}}
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
    </div>
</div>