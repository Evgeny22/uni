@extends('layouts.default')

@section('content')

<article class="full" id="activity">

    <h3><i class="icon icon-list"></i> Authored Activity</h3>

    <ul>
        @foreach ($authoredActivities as $activity)
            {!! $activity->render() !!}
        @endforeach
    </ul>

    <p><a href="{{ route('profile',['id'=>$user->id]) }}" class="btn btn-secondary">View Profile</a></p>

</article>

@endsection
