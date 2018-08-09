@extends('layouts.default')

@section('content')

<div id="popup">

    <article class="module remove-user">

        <h2 class="primary-bg">Remove User</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove this user? This can not be undone.</p>

            <form method="get" action="{{ route('users.delete', ['id' => $profile->id ]) }}">

                <button name="action" value="post" class="btn btn-primary" role="submit">Remove</button>
                <button name="action" value="cancel" class="btn btn-cancel">Close</button>

            </form>

        </div>

    </article>

</div>

<article class="full" id="profile-info">

    <div class="profile-pic col-md-3"><img src="{{ $profile->avatar->url() }}" alt="{{ $profile->display_name }}"></div>

    <div class="profile-details col-md-6">

        <h2 class="profile-name">{{ $profile->display_name }}</h2>
        <span class="profile-permission full">{{ $profile->role->display_name }}</span>
        <span class="profile-email full">{{ $profile->email }}</span>

        <div class="profile-bio">

            <p>{!! $profile->bio !!}</p>

        </div>

    </div>

    <div class="profile-options col-md-3">

        @if ($user->id == $profile->id or $user->is('super_admin'))
        <a href="{{ route('profile.edit', ['id' => $profile->id ]) }}" class="btn btn-success btn-sm">Edit Profile</a><br />
        <a href="{{ route('activity.authored', ['id' => $profile->id ]) }}" class="btn btn-sm btn-warning">View Authored Activity</a>
        @endif
        @if ($user->can('delete', $profile))
            <a href="#" class="btn btn-action btn-danger btn-sm" data-trigger="remove-user">Delete User</a>
        @endif

    </div>

</article>

@endsection
