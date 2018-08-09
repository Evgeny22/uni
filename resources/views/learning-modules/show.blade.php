@extends('layouts.default')

@section('content')

    @include('learning-modules.popups')

    <section class="learning-modules component">

        @include('learning-modules.top')

        <div class="row">

            <article class="module full">

                <h2>Learning Modules</h2>

                <div class="module-content pad-wide">

                    @include('partials.learning_module', [
                      'learningModule' => $learningModule,
                    ])

                </div>

            </article>

        </div>

    </section>

    <a href="{{ route('learning-modules.index') }}" class="view-all lm-color">View All Learning Modules</a>

@endsection
