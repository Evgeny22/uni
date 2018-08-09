<div class="add-comment full">

    <form method="POST" action="">
        {!! csrf_field() !!}

        <div class="full">

            <div class="profile-pic"><img src="{{ $message->author->avatar->url() }}" alt="{{ $message->author->name }}"></div>
            <textarea placeholder="Add a comment..."></textarea>

        </div>

        <div class="full">

            <button type="submit" class="btn btn-comment">Add Comment</button>

            <div class="attach">
                <i class="icon icon-attach" title="Attach a file"></i>
            </div>

        </div>

    </form>

</div>