<li class="activity vc">
    <a href="{{ route('video-center.show', ['id' => $exemplar->exemplarable_id]) }}">
        <span class="date-time">{{ $exemplar->created_at->diffForHumans() }}</span>
        <span class="activity-description">
            <strong>
                @if ($exemplar->author_id == $user->id)
                    You
                @else
                    {{ $exemplar->author->display_name }}
                @endif
            </strong> request
            <strong>
                "{{ $exemplar->exemplarable->title }}"
            </strong> to be approved in <strong class="vc-color">Video Center</strong>
        </span>
    </a>
</li>
