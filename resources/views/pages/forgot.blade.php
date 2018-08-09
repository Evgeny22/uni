@extends('layouts.page')

@section('content')
    ​
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 login-form">
                <div class="panel-header">
                    <h2 class="text-center">
                        <img src="{{ app('request')->root() }}/img/clear_black.png" alt="Coaching UP">
                    </h2>
                </div>
                <h3 class="text-center">Forgot Password
                </h3>
                <p class="text-center enter_email">
                    Enter your Registered email
                </p>
                <p class="text-center check_email hidden">
                    Check your email for Reset link
                    <br><br>
                    <u><a href="javascript:void(0)" class="reset-link">Resend the link</a></u>
                </p>
                @include('auth/password')
            </div>
        </div>
    </div>

    <!-- page level styles-->
    <link href="{{ app('request')->root() }}/vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <link href="{{ app('request')->root() }}/css/login.css" rel="stylesheet">
    <!-- end of page level styles-->
    <!-- page level js -->
    <script src="{{ app('request')->root() }}/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script src="{{ app('request')->root() }}/js/custom_js/forgot_password.js" type="text/javascript"></script>
    <!-- end of page level js -->

@endsection
