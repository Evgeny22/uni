@extends('layouts.default')

@section('content')

@include('learning-modules.popups')

<section class="learning-modules component">

    @include('learning-modules.top')

    <div class="row">

        <article class="module full">

            <h2>Learning Modules</h2>

            <div class="module-content pad-wide">

                @if(count($learningModules)>0)
                    @include('learning_modules_list')
                @else
                    <h3> There aren't Learning Modules.</h3>
                @endif

            </div>

        </article>

        {!! $learningModules->render() !!}

    </div>

</section>

@endsection
