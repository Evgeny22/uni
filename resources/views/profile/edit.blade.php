@extends('layouts.default')

@section('content')

<div class="row">

    <div class="panel panel-default" id="edit-profile">

        <div class="panel-heading">
            <h3 class="panel-title">
                Edit Profile
            </h3>
        </div>

        <div class="panel-body">

            <div class="col-md-12">

                @include('forms/edit-avatar')

            </div>

            <div class="full profile-info-edit">

                <div class="col-md-6">

                    @include('forms/edit-profile')

                </div>

                <div class="col-md-6">

                    <h3>Change Password</h3>

                    @include('forms/change-password')

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
