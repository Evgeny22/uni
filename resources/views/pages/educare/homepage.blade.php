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

{{--<header class="header">--}}

    {{--<nav class="navbar navbar-static-top row" role="navigation">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-9 col-sm-12 pull-left">--}}
                    {{--<a href="index.html" class="logo">--}}
                        {{--<!-- Add the class icon to your logo image or logo icon to add the margining -->--}}
                        {{--<img src="{{ app('request')->root() }}/img/clear_black.png" alt="Coaching UP" />--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="col-md-3 col-sm-12">--}}
                    {{--<a class="btn btn-success btn-block pull-right" href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Log In</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</nav>--}}
{{--</header>--}}
{{--<div class="wrapper row-offcanvas row-offcanvas-left">--}}
    {{--<!-- Left side column. contains the logo and sidebar -->--}}
    {{--<aside class="left-side sidebar-offcanvas collapse-left">--}}
        {{--<!-- sidebar: style can be found in sidebar-->--}}
        {{--<section class="sidebar">--}}
            {{--<!-- menu -->--}}
        {{--</section>--}}
        {{--<!-- /.sidebar -->--}}
    {{--</aside>--}}
    {{--<aside class="right-side right-side strech">--}}
            {{--<!-- Main content -->--}}
            {{--<section class="content">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="panel panel-esi">--}}
                            {{--<div class="panel-body">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-6">--}}

                                        {{--<h1 class="large-white" style="text-transform:inherit;">Coaching<br>UP</h1>--}}
                                        {{--<h3>Inquiry-Based Responsive Coaching</h3>--}}
                                        {{--</div>--}}
                                    {{--<div class="col-md-6 mascot hidden-xs">--}}
                                        {{--<img src="{{ app('request')->root() }}/img/ESI_mascot.png" />--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="row">--}}
                    {{--<div class="col-md-5">--}}
                        {{--<div class="panel panel-primary">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">--}}
                                    {{--Create a Family Account--}}
                                {{--</h3>--}}
                            {{--</div>--}}
                            {{--<div class="panel-body">--}}
                                {{--@include('auth/signup')--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-7">--}}
                        {{--<div class="panel gradient-color">--}}
                            {{--<div class="panel-body">--}}
                                {{--<article class="intro">--}}

                                    {{--<p>Science is everywhere! You can see it in the classroom when children build structures in the block area. You can find it in the sticky mess from a child’s melted Popsicle. You can feel it with the changing temperature as winter approaches.</p>--}}

                                    {{--<p>The early science initiative is about leveraging these naturally occurring science experiences to promote high-quality teaching and learning in early childhood classrooms.</p>--}}

                                    {{--<img src="{{ app('request')->root() }}/img/ESI_logos.png" alt="Buffet Early Childhood Fund - Univerysity of Miami - The Ounce - Educare Learning Network" class="intro-logos">--}}

                                    {{--<p class="funded-by">Funded by the Buffett Early Childhood Fund in collaboration with the University of Miami, the Ounce of Prevention, and the Educare Learning Network.</p>--}}

                                {{--</article>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</section>--}}
            {{--<!-- /.content -->--}}

{{--</div>--}}
{{--<script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/login.js"></script>--}}
@endsection