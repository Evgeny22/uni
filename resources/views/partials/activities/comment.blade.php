<?php

/**
 * Ensure data integrity of the notification.
 *
 * If we're missing a relationship, which means data was deleted, we won't show this notification.
 */
if (!isSet($activity) || !isSet($activity->activitied) || !isSet($activity->activitied->commentable)) {
    return;
}

?>

<li class="item">
    <a href="{{ $activity->activitied->url  }}" class="message icon-not striped-col">
        <div class="data">
            <div class="time text-muted"> {{ $activity->created_at->diffForHumans() }}</div>
            <p>
                <span class="activity-description">
                    <strong>
                        @if ($activity->author_id == $user->id)
                            You
                        @else
                            {{ $activity->author->name }}
                        @endif
                    </strong> commented on
                    <strong>
                        "{{ $activity->activitied->commentable->title }}"
                    </strong>
                </span>
            </p>
        </div>
    </a>
</li>
