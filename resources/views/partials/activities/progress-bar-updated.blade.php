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

<li class="item vc">
    <a href="{{ route('progress-bars.show', ['id' => $activity->activitied->id]) }}" class="message icon-not striped-col">
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
                    updated the Progress Bar
                    <strong>"{{ $activity->activitied->name }}"</strong>
                    @if ($user->id == $activity->activitied->author_id)
                        that you created.
                    @else
                        that you are a part of.
                    @endif
                </span>
            </p>
        </div>
    </a>
</li>