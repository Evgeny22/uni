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

@if ($activity->author_id == $user->id)
    You
@else
    {{ $activity->author->display_name }}
@endif
responded to the discussion
"{{ $activity->activitied->videoDiscussion->title }}"
in the video "{{ $activity->activitied->videoDiscussion->video->title }}"
@if ($user->id == $activity->activitied->videoDiscussion->video->author_id)
    that you uploaded
@else
    that was shared with you
@endif
