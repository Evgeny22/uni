@extends('layouts.default')

@section('content')

    <article class="full" id="activity">

        <h3><i class="icon icon-list"></i> Lesson Plans waiting for Approval</h3>

        <ul>
            @foreach ($exemplars as $exemplar)
                {!! $exemplar->render() !!}
            @endforeach
        </ul>

    </article>

    {!! $exemplars->render() !!}


@endsection


