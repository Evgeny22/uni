<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied) || !isSet($activity->activitied->progressBar)) {
    return;
}

?>

You need to complete step "{{ $activity->activitied->name }}" in the Progress Bar "{{ $activity->activitied->progressBar->name }}"
@if ($user->id == $activity->activitied->author_id)
that you created.
@else
that you are a part of.
@endif