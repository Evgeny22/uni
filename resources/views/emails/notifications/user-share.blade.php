<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied)) {
    return;
}

$userShareObject = $activity->activitied->object;
$objectRoute = '';
$objectHumanText = '';
$objectTitle = '';

switch (get_class($userShareObject->data)) {
    case \App\Video::class:
        $objectRoute = route('video-center.show', ['id' => $userShareObject->data->id]);
        $objectHumanText = 'video';
        $objectTitle = $userShareObject->data->title;
        break;

    case \App\ProgressBar::class:
        $objectRoute = route('progress-bars.show', ['id' => $userShareObject->data->id]);
        $objectHumanText = 'progress bar';
        $objectTitle = $userShareObject->data->name;
        break;
}

?>

@if ($activity->author_id == $user->id)
    You
@else
    {{ $activity->author->display_name }}
@endif

shared {{ $objectHumanText }} "{{ $objectTitle }}"
