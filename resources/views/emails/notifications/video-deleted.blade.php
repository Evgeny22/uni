<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied)) {
    return;
}

?>

@if ($activity->author_id == $user->id)
    You
@else
    {{ $activity->author->display_name }}
@endif
deleted the video

    "{{ $activity->activitied->title }}"
 from the Video Center
@if ($activity->author_id == $user->id)

@else
    that was shared with you
@endif
