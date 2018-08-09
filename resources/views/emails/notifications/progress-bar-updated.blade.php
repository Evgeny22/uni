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

updated the Progress Bar
"{{ $activity->activitied->name }}"
@if ($user->id == $activity->activitied->author_id)
    that you created.
@else
    that you are a part of.
@endif
