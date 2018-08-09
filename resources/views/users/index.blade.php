@extends('layouts.default')

@section('content')

<div id="popup">

    <article class="module new-user">

        <h2 class="primary-bg">Create a New User +</h2>

        <div class="module-content">

            <p>All fields are required. Email must currently not exist in the system.</p>

            <form method="post" action="{{ route('users.store') }}">
                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="text" name="name" title="Name" class="required" id="sign-up-name" placeholder="Name" value="{{ old('name') }}">

                <input type="email" name="email" placeholder="Email Address" title="Email" class="required" data-email id="sign-up-email" value="{{ old('email') }}">

                <div class="styled-select" for="user_role">

                    <select name="user_role" id="user-role" class="required" title="Role">
                        <option selected="selected" value="">Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                        <!-- ## FOREACH ALL ROLES IN DB SANS SUPER ADMIN ... IF NOT PROJECT ADMIN SELECTED, THEN DISPLAY SCHOOL/CLASSROOM DROPDOWNS BELOW AS A REQUIREMENT ## -->
                    </select>

                </div>

                <script>
                    var schools = {!! $schools !!}
                </script>

                <!-- ## 2 DROPDOWNS BELOW SHOULD ONLY BE DISPLAYED IF ROLE HAS BEEN SELECTED AND IT IS NOT PROJECT ADMIN... ONLY REQUIRED IF NOT A PROJECT ADMIN ## -->

                <div class="styled-select" for="school_id">

                    <select name="school_id" id="sign-up-school">

                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach

                    </select>

                </div>

                <div class="styled-select" for="classroom_id">

                    <select name="classroom_id" id="sign-up-classroom"></select>

                </div>

                <div class="styled-select" for="masterteacher">

                    <select name="masterteacher" id="sign-up-masterteacher"></select>

                </div>

                <button name="action" value="post" class="btn btn-primary" role="submit">Create</button>
                <button name="action" value="cancel" class="btn btn-cancel">Close</button>

            </form>

        </div>

    </article>

</div>

<section class="users component">

    {{--<div class="row component-top">--}}

        {{--<div class="button">--}}

            {{--<a href="#" class="btn btn-action" data-trigger="new-user">Create a New User +</a>--}}

        {{--</div>--}}

        {{--<div class="options">--}}


        {{--</div>--}}

    {{--</div>--}}
    <div class="row component-top">



        <button type="button" class="btn btn-labeled btn-success btn-action" data-trigger="new-user">
                                                <span class="btn-label">
                                                <i class="ti-id-badge"></i>
                                            </span> New User
        </button>

    </div>

    <div class="row">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Users
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            @if ($user->is('super_admin') or $user->is('mod'))
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>

                    @foreach($users as $listUser)

                        <tr data-user-id="{{ $listUser->id }}" id="comment-id-{{ $listUser->id }}">
                            <td><a href="{{ route('profile', ['id' => $listUser->id ]) }}">
                                        <span class="profile-pic">
                                            <img src="{{ $listUser->avatar_url }}" alt="{{ $listUser->display_name }}"></span> {{ $listUser->display_name }}</a></td>
                            <td><a href="mailto:{{ $listUser->email }}">
                                    <i class="ti-comment-alt"></i> {{ $listUser->email }}
                                </a>
                            </td>
                            @if ($user->is('super_admin') or $user->is('mod'))
                                <td>
                                    <div class="comment-actions">
                                        <a href="{{ route('profile', ['id' => $listUser->id ]) }}/edit" class="btn btn-action btn-info">Edit Profile</a>
                                    </div>
                                </td>
                            @endif
                        </tr>

                        {{--<div class="col-md-4 col-lg-4 col-sm-6 bord">--}}
                            {{--<div class="well well-sm">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<div class="img">--}}
                                        {{--<a href="{{ route('profile', ['id' => $listUser->id ]) }}">--}}
                                            {{--<img class="media-object thumbnail img-responsive" height="60" width="60" src="{{ $listUser->avatar_url }}" alt="{{ $listUser->display_name }}">--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-9">--}}
                                    {{--<div class="details">--}}
                                        {{--<div class="name">--}}
                                            {{--<a href="{{ route('profile', ['id' => $listUser->id ]) }}">{{ $listUser->display_name }}</a>--}}
                                        {{--</div>--}}
                                        {{--<br>--}}
                                        {{--<a href="mailto:{{ $listUser->email }}" class="btn btn-primary btn-xs">--}}
                                            {{--<i class="ti-comment-alt"></i> Send Email--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    @endforeach
                </div>
        </div>
    </div>

        {!! $users->render() !!}

    </div>

</section>
<script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/js//custom_js/datatables_custom.js"></script>
@endsection
