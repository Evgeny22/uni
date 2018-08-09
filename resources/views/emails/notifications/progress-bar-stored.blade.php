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

created
"{{ $activity->activitied->name }}",
@if ($user->id == $activity->activitied->author_id)
    a Progress Bar.
@else
    a Progress Bar and assigned you at least 1 task.
@endif
