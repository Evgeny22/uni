@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 login-form">
                <div class="panel-header">
                    <h2 class="text-center">
                        <img src="{{ app('request')->root() }}/img/clear_black.png" alt="The Early Science Initiative">
                    </h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @include('auth/login')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--page level css -->
    <link type="text/css" href="{{ app('request')->root() }}/vendors/themify/css/themify-icons.css" rel="stylesheet"/>
    <link href="{{ app('request')->root() }}/vendors/iCheck/css/all.css" rel="stylesheet">
    <link href="{{ app('request')->root() }}/vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <link href="{{ app('request')->root() }}/css/login.css" rel="stylesheet">
    <!--end page level css-->
    <!-- page level js -->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/iCheck/js/icheck.js"></script>
    <script src="{{ app('request')->root() }}/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/login.js"></script>
    <!-- end of page level js -->

@endsection
