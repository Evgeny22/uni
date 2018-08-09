@foreach ($lessonPlans as $lessonPlan)
    @if($lessonPlan->author)
        @include('partials.lesson_plan', $lessonPlan)
    @endif
@endforeach
