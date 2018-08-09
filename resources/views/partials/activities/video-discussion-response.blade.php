<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied) || !isSet($activity->activitied->videoDiscussion) || !isSet($activity->activitied->videoDiscussion->video)) {
    return;
}

?>
<li class="item vc">
    <a href="{{ route('video-center.show', ['id' => $activity->activitied->videoDiscussion->video->id]) }}" class="message icon-not striped-col">
        <div class="data">
            <div class="time text-muted"> {{ $activity->created_at->diffForHumans() }}</div>
            <p>
                <span class="activity-description">
                    <strong>
                        @if ($activity->author_id == $user->id)
                            You
                        @else
                            {{ $activity->author->display_name }}
                        @endif
                    </strong>
                    responded to the discussion
                    <strong>"{{ $activity->activitied->videoDiscussion->title }}"</strong>
                    in the video <strong>"{{ $activity->activitied->videoDiscussion->video->title }}"</strong>
                    @if ($user->id == $activity->activitied->videoDiscussion->video->author_id)
                        that you uploaded
                    @else
                        that was shared with you
                    @endif
                </span>
            </p>
        </div>
    </a>
</li>
