@foreach ($learningModules as $learningModule)
    @include('partials.learning_module', $learningModule)
@endforeach
