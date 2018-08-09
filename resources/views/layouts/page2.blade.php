<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.medium-editor-head')
    <link href="{{ app('request')->root() }}/css/layouts.css" rel="stylesheet">
    <link href="{{ app('request')->root() }}/css/mini_sidebar.css" rel="stylesheet">
    @yield('css')
</head>

<body class="mini_sidebar fixed-menu internal skin-default forum">
<div class="preloader">
    <div class="loader_img"><img src="{{ app('request')->root() }}/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
{{--@include('includes.dropdowns')--}}
@if ($user)
    <header class="header">
        <nav class="navbar navbar-fixed-top" role="navigation">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="{{ app('request')->root() }}/img/clear_black.png" alt="The Early Science Initiative" />
            </a>
            <!-- Header Navbar: style can be found in header-->
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                            class="fa fa-fw ti-menu"></i>
                </a>
            </div>
            <!-- Sidebar toggle button-->
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!--rightside toggle-->
                    <li>
                        <a href="javascript:void(0)" class="dropdown-toggle toggle-right notifications-bubble" data-user-id="{{ $user->id }}">
                            <i class="fa fa-fw ti-bell black"></i>
                            <span class="label label-danger">{{ $activities->count() }}</span>
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="javascript:void(0)" class="dropdown-toggle padding-user" data-toggle="dropdown">
                            <img src="{{ $user->avatar->url() }}" width="35" class="img-circle img-responsive pull-left"
                                 height="35" alt="{{ $user->display_name }}">
                            <div class="riot">
                                <div>
                                    {{ $user->display_name }}
                                    <span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ $user->avatar->url() }}" class="img-circle" alt="User Image">
                                <p> {{ $user->display_name }}</p>
                            </li>
                            <!-- Menu Body -->
                            <li class="p-t-3">
                                <a href="{{ route('profile', ['id' => $user->id ]) }}">
                                    <i class="fa fa-fw ti-user"></i> My Profile
                                </a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#">
                                        <i class="fa fa-fw ti-help-alt"></i> Help
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}">
                                        <i class="fa fa-fw ti-shift-right"></i> Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
@endif

<div class="wrapper row-offcanvas row-offcanvas-left">
    @include('includes.nav')
    <aside class="right-side fixednav_right">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Forum</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    @include('flash')

                    @yield('content')
                </div>
            </div>
            <!--rightside bar -->
            <div id="right">
                <div id="right-slim">
                    <div class="rightsidebar-right">
                        <div class="rightsidebar-right-content">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="r_tab2">
                                    <div id="slim_t2">
                                        <h5 class="rightsidebar-right-heading text-uppercase text-xs">
                                            <i class="fa fa-fw ti-bell"></i>
                                            Notifications
                                        </h5>
                                        <ul class="list-unstyled m-t-15 notifications">
                                            @foreach ($activities as $activity)
                                                {!! $activity->render() !!}
                                            @endforeach
                                            <li class="text-right noti-footer"><a href="javascript:void(0)">View All Notifications <i class="ti-arrow-right"></i></a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
    </aside>
</div>
<div id="userParticipantImage" style="display:none;">
    <img data-name="{{ $user->display_name }}" class="participant" alt="{{ $user->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $user->display_name }}" />
</div>
<div id="userName" style="display:none;">
    {{ $user->display_name }}
</div>

<script src="{{ app('request')->root() }}/js/app.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/select2.min.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.tooltipster.min.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.scrollTo.min.js"></script>
<script src="{{ app('request')->root() }}/js/underscore.min.js"></script>
<!--<script src="{{ app('request')->root() }}/js/global.min.js?<?php echo bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));?>"></script>-->
<script src="{{ app('request')->root() }}/js/global.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/layout_custom.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/mini_sidebar.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.sessionTimeout.min.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/session_timeout.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/initial.js" type="text/javascript"></script>

@yield('js')

</body>
</html>