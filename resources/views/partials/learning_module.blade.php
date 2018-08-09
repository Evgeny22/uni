<article class="component-list">

    <div class="component-list-top">

        @if ($learningModule->isAuthoredBy($user) or $user->is('super_admin'))

            <div class="post-modifications">

                <i class="icon icon-edit" title="Edit Post" data-trigger="edit-post"></i>
                <i class="icon icon-remove" title="Remove Post" data-trigger="remove-post"></i>

            </div>

        @endif

        <div class="component-list-details">

            <div class="post-top">

                <div class="profile-pic"></div>

                <div class="post-title">
                    <h4><a href="{{ route('learning-modules.show', [ 'id' => $learningModule->id ]) }}">{{ $learningModule->title }}</a></h4>
                    <div class="date-time">{{ $learningModule->updated_at->diffForHumans() }}</div>
                </div>

            </div>

            <div class="post-message">

                {!! $learningModule->description !!}

            </div>

            @if (isset($learningModule->wistia_hashed_id))

                <div class="full video-embed-contain">

                    <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><iframe src="//fast.wistia.net/embed/iframe/{{ $learningModule->wistia_hashed_id }}?videoFoam=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="100%" height="100%" id="drumpf"></iframe></div></div>
                    <script src="//fast.wistia.net/assets/external/E-v1.js" async></script>

                </div>

            @elseif (isset($learningModule->zoom_url) and !isset($learningModule->wistia_hashed_id))

                <p><br>Link: <a href="{{ $learningModule->zoom_url }}" class="lm-color zoom-url" target="_blank">{{$learningModule->zoom_url}}</a></p>

            @endif

            {{--@if ($user->is('super_admin') or $learningModule->isAuthoredBy($user))

                <div class="button">

                    <a href="#" class="btn btn-action" data-trigger="video-update">Upload Video</a>

                </div>

            @endif--}}

        </div>

            <article class="module supporting-docs">

                <h2 class="secondary-bg">Supporting Documents</h2>

                <div class="module-content">

                    @include('partials.supporting-documents', [
                        'docs' => $learningModule->documents
                    ])

                </div>

            </article>

    </div>

</article>