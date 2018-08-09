<article class="post" data-id="{{$resource->id}}">

    <div class="post-top">

        <div class="post-title">

            <a href="{{ route('resources.show', ['id' => $resource->id]) }}">
                <h4>{{ $resource->title }}</h4>
            </a>

            <div class="date-time">{{ $resource->updated_at->diffForHumans() }}</div>

        </div>

        <div class="post-modifications">

            @if ($resource->isAuthoredBy($user) or $user->is('super_admin'))

                <div class="post-modifications">

                    <i class="icon icon-edit" title="Edit Post" data-trigger="edit-post"></i>
                    <i class="icon icon-remove" title="Remove Post" data-trigger="remove-post"></i>

                </div>

            @endif

        </div>

    </div>

    <div class="post-message">

        <p class="description">{!! $resource->description !!}</p>
        <p>&nbsp;</p>

    </div>

    @if(strlen($resource->document_path())>0)
        <a href="{{$resource->document_path()}}" target="_blank" class="btn btn-action btn-inline float-left document-url" data-name="{{$resource->documents->first()->title}}">Download Resource Document</a>
    @endif
    @if(strlen($resource->remote_url)>0)
        <a href="{{$resource->remote_url}}" target="_blank" class="float-left remote-url">{{$resource->remote_url}}</a>
    @endif
</article>