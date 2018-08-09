@include('includes/header')

<article class="full" id="profile-info">

    <div class="profile-pic"><img src="{{ $user->avatar->url() }}" alt="{{ $user->display_name }}"></div>

    <div class="profile-details">

        <h2 class="profile-name">{{ $user->display_name }}</h2>
        <span class="profile-permission full">Project Admin</span>
        <span class="profile-email full">{{ $user->email }}</span>

        <div class="profile-bio">

            <p>{!! $user->bio !!}</p>

        </div>

    </div>

    <div class="profile-options">

        <a href="{{ route('edit-profile') }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('authored-activity') }}" class="btn btn-secondary">View Authored Activity</a>

    </div>

</article>


@include('includes/footer')
