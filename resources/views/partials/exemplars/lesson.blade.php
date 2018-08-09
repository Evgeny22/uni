<li class="activity id">
    <a href="{{ route('instructional-design.show', ['id' => $exemplar->exemplarable_id]) }}">
        <span class="date-time">{{ $exemplar->created_at->diffForHumans() }}</span>
        <span class="activity-description">
            <strong>
                @if ($exemplar->author_id == $user->id)
                    You
                @else
                    {{ $exemplar->author->display_name }}
                @endif
            </strong> posted
            <strong>
                "{{ $exemplar->exemplarable->title }}"
            </strong> to be approved in <strong class="id-color">Instructional Design</strong>
        </span>
    </a>
</li>
