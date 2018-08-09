<form
    method="POST"
    data-toggle="validator"
    data-page="{{$page}}"
    action="
@if ($page == 'message' || $page == 'dashboard')
{{ route('api.messages.comments.store', ['id' => $message->id]) }}
@elseif ($page == 'video')
{{ route('api.video-center.comments.store', ['id' => $video->id]) }}
@elseif ($page == 'instructional-design-show')
{{ route('api.instructional-design.comments.store', ['id' => $lessonPlan->id]) }}
@elseif ($page == 'resource' || $page == 'resources')
{{ route('resources.store-comment', ['id' => $resource->id]) }}
@elseif ($page == 'progress-bars')
{{ route('progress-bars.store-comment', ['id' => $progressBar->id]) }}
@endif"
      class="comment-form">
        {!! csrf_field() !!}
        <input type="hidden" name="parent_id" class="comment_parent_id" value="" />

        <div class="form-group">
            <div class="col-md-1">
                <div class="profile-pic" id="userParticipantImage">
                    <a href="{{ route('profile', ['id' => $user->id ]) }}" class="profile-url">
                        <img src="{{ $user->avatar->url() }}" alt="{{ $user->display_name }}" class="img-circle" />
                    </a>
                </div>
            </div>
            <div class="col-md-11">
                {{--<label for="content" class="control-label">Reply</label>--}}
                <div id="reply-to" style="display:none;">
                    <span>Replying to</span>: <span class="author"></span> <br />
                    <blockquote class="body"></blockquote>

                    <p>[<a class="cancel-sub-comment" href="#">Cancel</a>]</p>
                </div>
                <textarea required id="content" rows="4" class="form-control resize_vertical no-ck-editor" name="content" placeholder="What do you have to say?"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11" style="margin-top: 10px;">
                <button type="submit" class="btn btn-comment btn-success btn-sm">Submit</button>
            </div>
        </div>

        @if (isset($type))
            <input type="hidden" name="type" value="{{ $type }}">
        @endif

        @if ($page == 'video')
            <input type="hidden" name="video-comment" value="true">
            <!--<div class="timestamp">

                <span class="stamp">
                    <input name="minutes" type="number" value="0">
                    <span class="colon">:</span>
                    <input name="seconds" type="number" value="00">
                </span>

                <button type="button" class="btn btn-action" id="time-stamp-comment">Add Timestamp</button>

            </div>-->
        @endif
</form>
