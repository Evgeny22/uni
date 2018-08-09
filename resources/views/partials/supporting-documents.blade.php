<ul class="link-list">

    @foreach ($docs as $doc)

        <li><a href="{{ $doc->path }}" target="_blank" data-target="{{ $doc->id }}"><i class="fa fa-file-@if ($doc->extension == 'docm' || $doc->extension == 'docx' || $doc->extension == 'doc')word-o @elseif  ($doc->extension == 'pdf')pdf-o @elseif  ($doc->extension == 'jpeg' || $doc->extension == 'jpg' || $doc->extension == 'gif' || $doc->extension == 'tiff' || $doc->extension == 'png')image-o @elseif  ($doc->extension == 'xls' || $doc->extension == 'xlsx')excel-o @endif"></i> {{ strlen($doc->description) > 0 ? $doc->description : $doc->title }}</a>

            {{--@if (( (isset($video) && $video->isAuthoredBy($user)) or (isset($learningModule) && $learningModule->isAuthoredBy($user)) ) or $user->is('super_admin'))

                @if ($page != 'learning-modules')--}}

                {{--<i class="ti-close text-danger" title="Remove Document" data-trigger="remove-document"></i>--}}
                        <button type="button" class="btn btn-danger" data-trigger="remove-document">Delete</button>

                {{--@endif

            @endif--}}

        </li>

    @endforeach

    @if(count($docs) == 0)

        <li>
                <div class="alert alert-info">
                        <strong>Heads up!</strong> There currently aren't any supporting documents.
                </div>
        </li>

    @endif

    @if (( (isset($video) && $video->isAuthoredBy($user)) or (isset($learningModule) && $learningModule->isAuthoredBy($user)) or (isset($lessonPlan) && $lessonPlan->isAuthoredBy($user)) ) or $user->is('super_admin') or $user->is('mod') or $user->is('teacher'))

        @if ($page != 'learning-modules')

        <li><a href="#" data-trigger="new-document" class="btn btn-primary btn-xs" style="margin-top: 12px;">Upload Supporting Document</a></li>

        @else

        <li><span>*To modify Supporting Documents for this post, click on the post title.</span></li>

        @endif

    @endif

</ul>

