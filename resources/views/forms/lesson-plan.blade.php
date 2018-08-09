<form class="lesson-plan-form" method="post" action="{{ route('instructional-design.update', ['instructional_design' => $lessonPlan->id]) }}">

    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="hasAnswers" value="1">

    {{ csrf_field() }}

    <div class="full">
        <label for="learning-objective">Learning objective (include a practice, crosscutting concept, & core idea)</label>
        <textarea name="learning-objective">@if(count($answers) > 0){{ $answers->get('learning-objective') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="crosscutting-concepts">Crosscutting Concepts</label>
        <ul>
            @if(count($answers) > 0)
                @foreach($crosscuttingConcepts as $crosscuttingConcept)
                    <li><input type="checkbox" name="{{$crosscuttingConcept->name_checkbox}}" value="checked" {{ $answers->get($crosscuttingConcept->name_checkbox) ? 'checked' : '' }}> {{$crosscuttingConcept->tag}}</li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="full">
        <label for="practices">Practices</label>
        <ul>
            @if(count($answers) > 0)
                @foreach($practices as $practice)
                    <li><input type="checkbox" name="{{$practice->name_checkbox}}" value="checked" {{ $answers->get($practice->name_checkbox) ? 'checked' : '' }}> {{$practice->tag}}</li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="full">
        <label for="core-ideas">Core Ideas</label>
        <ul>
            @if(count($answers) > 0)
                @foreach($coreIdeas as $coreIdea)
                    <li><input type="checkbox" name="{{$coreIdea->name_checkbox}}" value="checked" {{ $answers->get($coreIdea->name_checkbox) ? 'checked' : '' }}> {{$coreIdea->tag}}</li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="full">
        <label for="questions-to-assess-understanding">Questions to assess understanding (what crosscutting concepts are being assessed with each question)</label>
        <textarea name="questions-to-assess-understanding">@if(count($answers) > 0){{ $answers->get('questions-to-assess-understanding') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="format-used">Format Used</label>
        <ul>
            <li><input type="radio" name="format-used" value="small" @if(count($answers) > 0){{ $answers->get('format-used') == 'small' ? 'checked' : '' }}@endif> Small Group</li>
            <li><input type="radio" name="format-used" value="free" @if(count($answers) > 0){{ $answers->get('format-used') == 'free' ? 'checked' : '' }}@endif> Centers/Free Choice</li>
            <li><input type="radio" name="format-used" value="other" @if(count($answers) > 0){{ $answers->get('format-used') == 'other' ? 'checked' : '' }}@endif> Other</li>
        </ul>
    </div>

    <div class="full">
        <label for="keywords">Keywords</label>
        <textarea name="keywords">@if(count($answers) > 0){{ $answers->get('keywords') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="materials">Materials</label>
        <textarea name="materials">@if(count($answers) > 0){{ $answers->get('materials') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="procedure">Procedure (How will you introduce the experience to children? How will you support them throughout the experience? How will you summarize the learning for them? Identify key practices within your procedure)</label>
        <textarea name="procedure">@if(count($answers) > 0){{ $answers->get('procedure') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="ideas">Ideas to connect, deepen, or extend the experience</label>
        <textarea name="ideas">@if(count($answers) > 0){{ $answers->get('ideas') }}@endif</textarea>
    </div>

    <div class="full">
        <label for="notes-and-reflections">Notes &amp; reflections: (Did the children meet the learning objective? Why or why not? What was surprising or unexpected about how children engaged in this lesson? What else did they figure out (what other crosscutting concepts, core ideas, or practices)? What modifications would you make to this lesson in the future? How will you use what you learned about the children to plan another experience?)</label>
        <textarea name="notes-and-reflections">@if(count($answers) > 0){{ $answers->get('notes-and-reflections') }}@endif</textarea>
    </div>
    
    @if ($lessonPlan->isAuthoredBy($user) or $user->is('super_admin') or $lessonPlan->hasParticipant($user))
        <button name="action" value="post" class="btn btn-success" type="submit" role="submit">Save</button>
    @endif

    @if ($lessonPlan->isAuthoredBy($user) or $user->is('super_admin') or $lessonPlan->hasParticipant($user))
    @else
        <script>
            $( document ).ready(function() {
                $('.lesson-plan-form').find('input, textarea, button, select').attr('disabled','disabled');
            });
        </script>
    @endif
</form>
