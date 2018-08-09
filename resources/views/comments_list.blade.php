@if (count($comments) > 0)
    <div class="comments">
    @foreach ($comments as $commentIndex => $comment)
        @if ($comment->parent_id == '')
        <ul class="timeline-update timeline-comments comment-wrapper" data-comment-id="{{ $comment->id }}" id="comment-id-{{ $comment->id }}" data-comment-index="{{$commentIndex}}">
            <li>
                <div class="timeline-badge center">
                    <a href="{{ route('profile', ['id' => $comment->author->id ]) }}">
                        <img src="{{ $comment->author->avatar->url() }}" height="36" width="36" class="img-circle pull-right" alt="{{ $comment->author->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $comment->author->display_name }}" />
                        {{--<img data-name="{{ $comment->author->display_name }}" class="participant" alt="{{ $comment->author->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $comment->author->display_name }}" />--}}
                    </a>
                </div>
                <div class="timeline-panel" style="display:inline-block;">
                    <div class="timeline-heading">
                        <p>
                            <small class="text-default-gray">{{ $comment->updated_at->format('D, d M Y H:i a') }} <a href="{{ route('profile', ['id' => $comment->author->id ]) }}" class="author"> {{ $comment->author->display_name }}</a></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <p>
                            {!! $comment->content !!}
                        </p>
                    </div>

                    <div class="timeline-footer">
                        <div class="btn-group pull-right" role="group" aria-label="Actions" style="margin-top: 5px;">
                            @if (isSet($can_reply) && $can_reply === true)
                            <a class="btn btn-success btn-xs comment-reply" data-comment-id="{{ $comment->id }}" href="#">Reply</a>
                            @endif


                            {{-- The only comment that can be deleted is the last comment --}}

                            @if ($commentIndex == $comments->count() - 1)
                                {{-- This comment can be deleted, it is the last comment (no comments after it/responded to it) --}}
                                @if (($user->is('super_admin') or $user->is('mod')) or $comment->isAuthoredBy($user) and count($comment->subComments) == 0)
                                <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="{{ route('api.video-center.comments.destroy', ['id' => $comment->id]) }}" data-comment-id="{{ $comment->id }}">
                                    Delete
                                </button>
                                @endif
                            @else
                                {{-- This comment cannot be deleted --}}
                                @if (($user->is('super_admin') or $user->is('mod')) or $comment->isAuthoredBy($user) and count($comment->subComments) == 0)
                                    {{--<button type="button" class="btn btn-xs btn-action btn-danger cannot-delete-comment" data-route="{{ route('api.video-center.comments.destroy', ['id' => $comment->id]) }}" data-comment-id="{{ $comment->id }}">--}}
                                        {{--Delete--}}
                                    {{--</button>--}}
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </li>
        </ul>
        @endif

        @if (count($comment->subComments) > 0)
            @foreach ($comment->subComments as $subComment)
                <ul class="timeline-update timeline-comments timeline-subcomment comment-wrapper" data-comment-id="{{ $subComment->id }}" data-parent-comment-id="{{$subComment->parent_id}}" id="comment-id-{{ $subComment->id }}">
                    <li>
                        <div class="timeline-badge center">
                            <a href="{{ route('profile', ['id' => $subComment->author->id ]) }}">
                                <img src="{{ $subComment->author->avatar->url() }}" height="36" width="36" class="img-circle pull-right" alt="{{ $subComment->author->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $subComment->author->display_name }}" />
                                {{--<img data-name="{{ $subComment->author->display_name }}" class="participant" alt="{{ $subComment->author->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $subComment->author->display_name }}" />--}}
                            </a>
                        </div>
                        <div class="timeline-panel" style="display:inline-block;">
                            <div class="timeline-heading">
                                <p>
                                    <small class="text-default-gray">{{ $subComment->updated_at->format('D, d M Y H:i a') }} <a href="{{ route('profile', ['id' => $subComment->author->id ]) }}" class="author"> {{ $subComment->author->display_name }}</a></small>
                                </p>
                            </div>
                            <div class="timeline-body">
                                <p>
                                    {!! $subComment->content !!}
                                </p>
                            </div>
                            <div class="timeline-footer">
                                <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">
                                    <a class="btn btn-success btn-xs comment-reply" data-comment-id="{{ $comment->id }}" href="#">Reply</a>
                                    @if ($user->is('super_admin') or $user->is('mod'))
                                        <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="{{ route('api.video-center.comments.destroy', ['id' => $subComment->id]) }}" data-comment-id="{{ $subComment->id }}">Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        @endif
    @endforeach
    </div>
@else
    <!--<div class="alert alert-info alert-dismissable" style="margin: 0 18px;">
        <strong> Heads up!</strong> There are no comments yet.
    </div>-->

    <div class="comments"></div>
@endif

