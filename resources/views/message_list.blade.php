@foreach ($messages as $message)
    @if(!in_array($message->id, $deletedMessagesIds))
        @if($message->author)
            @include('partials.message', $message)
        @endif
    @endif
@endforeach
