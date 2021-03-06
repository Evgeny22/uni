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

<li class="item mb">
    <a href="{{ route('messages.show', [ 'id' => $activity->activitied_id ]) }}" class="message icon-not striped-col">
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
                    </strong> posted
                    <strong>
                        "{{ $activity->activitied->title }}"
                    </strong> to the <strong class="mb-color">Message Board</strong>
                    @if ($activity->author_id == $user->id)

                    @else
                        and tagged you
                    @endif
                </span>
            </p>
        </div>
    </a>
</li>