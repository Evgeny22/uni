<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.medium-editor-head')
    <link href="{{ app('request')->root() }}/css/layouts.css" rel="stylesheet">
    <link href="{{ app('request')->root() }}/css/mini_sidebar.css" rel="stylesheet">
</head>

<body class="mini_sidebar fixed-menu internal skin-default">
<div class="preloader">
    <div class="loader_img"><img src="img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
{{--@include('includes.dropdowns')--}}


<div class="wrapper row-offcanvas row-offcanvas-left">
@include('includes.nav')
<aside class="right-side fixednav_right">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $title }}</h1>
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
<!--<script src="{{ app('request')->root() }}/js/user-idle.js"></script>-->
<script src="{{ app('request')->root() }}/js/proajax.js"></script>

@include('includes.medium-editor-footer')
@include('includes.wistia-footer')

</body>
</html>
