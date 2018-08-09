@if (isset($activities))
<div class="dropdown dropdown-alerts">
    <ul>
        @foreach ($activities as $activity)
            {!! $activity->render() !!}
        @endforeach

        @if(count($activities)>0)

                <li><a href="{{ route('activity',['id'=>$user->id]) }}" class="prominent">View All Activity</a></li>

        @endif
    </ul>
</div>
@endif

<div class="dropdown dropdown-sort">
    <ul>
        <li><a href="{{  URL::current().'?sort=desc'. (Request::has('tags')?"&search=true&tags=". str_replace(" ", "+", Request::get('tags')) : "") }}" class="@if (app('request')->input('sort') != 'asc' AND  app('request')->input('sort') != 'exemplar') checked @endif">Most Recent</a></li>
        <li><a href="{{  URL::current().'?sort=asc'. (Request::has('tags')?"&search=true&tags=". str_replace(" ", "+", Request::get('tags')) : "") }}" class="@if (app('request')->input('sort') == 'asc') checked @endif">Oldest First</a></li>
        @if ($page == 'video-center'|| $page == 'instructional-design')
        <li><a href="{{  URL::current().'?sort=exemplar'. (Request::has('tags')?"&search=true&tags=". str_replace(" ", "+", Request::get('tags')) : "") }}" class="@if (app('request')->input('sort') == 'exemplar') checked @endif">Exemplars</a></li>
        @endif
    </ul>

</div>

<div class="dropdown dropdown-account">

    <ul>
        <li><a href="{{ route('profile', ['id' => $user->id ]) }}">View Profile</a></li>
        <li><a href="{{ route('logout') }}" class="prominent">Log Out</a></li>
    </ul>

</div>
