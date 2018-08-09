<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied) || !isSet($activity->activitied->step) || !isSet($activity->activitied->step->progressBar)) {
    return;
}

?>

@if ($activity->author_id == $user->id)
    You
@else
    {{ $activity->author->display_name }}
@endif

started step "{{ $activity->activitied->step->name }}" in the Progress Bar "{{ $activity->activitied->step->progressBar->name }}"
@if ($user->id == $activity->activitied->author_id)
    that you created.
@else
    that you are a part of.
@endif
