<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/css/layouts.css">
    <link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/css/mini_sidebar.css">

    <script src="{{ app('request')->root() }}/js/app.js" type="text/javascript"></script>
</head>

<body id="{{ $page }}" class="mini_sidebar fixed-menu internal skin-default {{ $page }} mini">
<div class="preloader">
    <div class="loader_img"><img src="{{ app('request')->root() }}/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
@if ($user)
<header class="header">
        <nav class="navbar navbar-fixed-top" role="navigation">
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <i class="fa fa-fw ti-menu"></i>
                </a>
            </div>
            <!-- Sidebar toggle button-->
            <a href="{{ app('request')->root() }}/dashboard" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="{{ app('request')->root() }}/img/clear_black.png" alt="Coaching UP" />
            </a>
            <!-- Header Navbar: style can be found in header-->
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!--rightside toggle-->
                    <li>
                        {{--<a href="{{ route ('messages.index') }}" class="dropdown-toggle notifications-bubble" data-user-id="{{ $user->id }}">--}}
                        {{--<i class="fa fa-fw ti-comment-alt black"></i>--}}
                            {{--@if ($messages->count() > 0)--}}
                                {{--<span class="label label-danger">{{ $messages->count() }}</span>--}}
                            {{--@endif--}}
                        {{--</a>--}}
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="dropdown-toggle toggle-right notifications-bubble" data-user-id="{{ $user->id }}">
                            <i class="fa fa-fw ti-bell black"></i>
                            @if ($notificationsHeader->count() > 0)
                            <span class="label label-danger">{{ $notificationsHeader->count() }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Hidden --}}
                    {{--<li class="dropdown dropdown-toggle">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-fw ti-help-alt black"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw ti-menu-alt"></i> FAQs
                                </a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw ti-info-alt"></i> Help Center
                                </a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw ti-marker"></i> Report an Issue
                                </a>
                            </li>
                        </ul>
                    </li>--}}
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
                                <a href="{{ route('profile', ['id' => $user->id ]) }}" style="text-align: center;"><img src="{{ $user->avatar->url() }}" class="img-circle" alt="User Image"></a>
                                <p>{{ $user->display_name }}</p>
                            </li>
                            <!-- Menu Body -->
                            {{-- Hidden --}}
                            {{--<li>
                                <a href="{{ route('activity',['id'=>$user->id]) }}">
                                    <i class="fa fa-fw ti-pulse"></i> My Activity
                                </a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <a href="{{ route('profile', ['id' => $user->id ]) }}">
                                    <i class="fa fa-fw ti-user"></i> My Profile
                                </a>
                            </li>--}}
                            <li role="presentation" class="divider"></li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                {{-- Hidden --}}
                                {{--<div class="pull-left">
                                    <a href="#">
                                        <i class="fa fa-fw ti-help-alt"></i> Help
                                    </a>
                                </div>--}}
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

<div class="wrapper row-offcanvas row-offcanvas-left" style="height: 100%!important;">
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
                @if ($notificationsHeader->count())
                    @foreach ($notificationsHeader as $notification)
                        {!! $notification->render() !!}
                    @endforeach
                @else
                    <li>No unread notifications.</li>
                @endif
                <li class="text-right noti-footer">
                    <a href="{{ route('notifications.index') }}">Go to Notification Center <i class="ti-arrow-right"></i></a>
                </li>
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
@include('flash')
<!-- Share Object Modal -->
<div id="shareObjectModal" class="modal fade animated" aria-hidden="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Share</h4>

            </div>
            <form role="form" method="post" action="{{ route ('share') }}">
                {!! csrf_field() !!}
                <input type="hidden" id="object_id" name="object_id" value="" />
                <input type="hidden" id="object_type" name="object_type" value="" />
                <input type="hidden" id="filter_ids" name="filter_ids" class="js-participants-exclude-ids" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Share with</label>
                                <select id="participants[]" name="participants[]" title="Participants" class="form-control select2 participants-exclude required" multiple="multiple" style="width:100%"></select>
                            </div>
                        </div>
                    </div>
                    <div class="sharedWith">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="add_column">
                        <span class="glyphicon glyphicon-ok-sign"></span> Share
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Share Object Modal -->
@if ($user)
<div id="userParticipantImage" style="display:none;">
    <img data-name="{{ $user->display_name }}" class="participant" alt="{{ $user->display_name }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="left" data-original-title="{{ $user->display_name }}" />
</div>
<div id="userName" style="display:none;">
    {{ $user->display_name }}
</div>
@endif
<script src="{{ app('request')->root() }}/js/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/ckeditor/plugins/uploadcare/plugin.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/select2.min.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.tooltipster.min.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.scrollTo.min.js"></script>
<script src="{{ app('request')->root() }}/js/underscore.min.js"></script>
<!--<script src="{{ app('request')->root() }}/js/global.min.js?<?php echo bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));?>"></script>-->
@include('includes.wistia-footer')
@include('includes.medium-editor-footer')

<script src="{{ app('request')->root() }}/js/global.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/layout_custom.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/mini_sidebar.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.sessionTimeout.min.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/session_timeout.js"></script>
<script src="{{ app('request')->root() }}/js/custom_js/initial.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/bootbox.js"></script>
{{--
<script src="{{ app('request')->root() }}/vendors/moment/js/moment.min.js"></script>
--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>--}}
<script src="{{ app('request')->root() }}/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/inputmask/inputmask/inputmask.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/inputmask/inputmask/jquery.inputmask.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/inputmask/inputmask/inputmask.date.extensions.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/inputmask/inputmask/inputmask.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="{{ app('request')->root() }}/vendors/daterangepicker/js/daterangepicker.js" type="text/javascript"></script>
<!-- bootstrap time picker -->
<script src="{{ app('request')->root() }}/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/clockpicker/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/jquerydaterangepicker/js/jquery.daterangepicker.min.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/datedropper/datedropper.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/vendors/timedropper/js/timedropper.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/custom_js/datepickers.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js" type="text/javascript"></script>
<!-- end of page level js -->
</body>
</html>