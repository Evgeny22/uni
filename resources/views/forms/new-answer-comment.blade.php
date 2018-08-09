<form
    method="POST"
    action="{{ route('video.discussion.respondToAnswer', ['id' => $video->id]) }}"
    class="comment-form"
    data-toggle="validator"
    style="overflow: auto;">
        {!! csrf_field() !!}
        <input type="hidden" name="answer_id" class="answer_id" value="" />

        <div class="form-group">
            <div class="col-md-1">
                <div class="profile-pic"><img src="{{ $user->avatar->url() }}" alt="{{ $user->display_name }}"></div>
            </div>
            <div class="col-md-11">
                <label for="content" class="control-label">Reply</label>
                <div id="reply-to" style="display:none;">
                    <span>Replying to</span>: <span class="author"></span> <br />
                    <blockquote class="body"></blockquote>
                </div>
                <textarea required id="content" rows="4" class="form-control resize_vertical no-ck-editor" name="content" placeholder="What do you have to say?"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-11" style="margin-top: 10px;">
                <button type="submit" class="btn btn-comment btn-success">Submit</button>
            </div>
        </div>

        @if (isset($type))
            <input type="hidden" name="type" value="{{ $type }}">
        @endif
</form>
