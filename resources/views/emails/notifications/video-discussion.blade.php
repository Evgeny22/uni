<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied) || !isSet($activity->activitied->video)) {
    return;
}

?>

@if ($activity->author_id == $user->id)
    You
@else
    {{ $activity->author->display_name }}
@endif
added a new discussion "{{ $activity->activitied->title }}" to the video <strong>"{{ $activity->activitied->video->title }}"</strong>
@if ($activity->author_id == $user->id)

@else
    that was shared with you
@endif
