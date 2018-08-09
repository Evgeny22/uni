@include('includes/header')

<article class="full" id="activity">

    <h3><i class="icon icon-list"></i> Authored Activity</h3>

    @include('activity_list_all', [
      'activities' => $activities,
    ])

    <p><a href="{{ route('profile') }}" class="btn btn-secondary">View Profile</a></p>

</article>

@include('includes/footer')
