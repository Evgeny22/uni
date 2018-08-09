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

<li class="item vc">
    <a href="{{ $objectRoute }}" class="message icon-not striped-col">
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
                    <strong>
                        shared {{ $objectHumanText }} "{{ $objectTitle }}"
                    </strong>
                </span>
            </p>
        </div>
    </a>
</li>