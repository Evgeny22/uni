@extends('layouts.default')

@section('content')

<article class="full" id="activity">

    {{--<h3 class="float-right space-bottom"><a href="{{ route('profile', ['id' => $user->id ]) }}">&lt; View Your Profile</a></h3>--}}

    {{--<h3><i class="icon icon-list"></i> Activity</h3>--}}

    <div class="panel ">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="ti-pulse"></i>
                Activity
            </h3>
        </div>
        <div class="panel-body">
            <ul class="schedule-cont">
                @foreach ($profileActivities as $activity)
                    {!! $activity->render() !!}
                @endforeach
            </ul>
        </div>
    </div>
    
</article>

{!! $profileActivities->render() !!}

@endsection
