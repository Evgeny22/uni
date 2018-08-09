@extends('layouts.default')

@section('content')

@include('progress-bars/popups', ['progressBarTemplates' => $progressBarTemplates])
    <script>
        var progressBars = {!! $progressBars !!}
    </script>
    <div class="row component-top">
        @if($user->is('super_admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher'))
        <button class="btn btn-success create-progress-bar btn-sm" data-toggle="modal" data-target="#createProgressBarModal" title="Create Progress Bar" type="button">Create Progress Bars</button>
        @endif
        <button type="button" class="btn btn-sm btn-warning btn-action btn-search" data-action="search">Search</button>
    </div>
    <div class="search-form">
        @include('partials/search_form', [
            'searchAction' => route('progress-bars.search'),
            'cancelAction' =>route('progress-bars.index'),
            'hideTags' => false,
            'prefilled' => isSet($prefilled) ? $prefilled : null
        ])
    </div>
    <div class="row">
        <!--tab starts-->
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs">
            @if (request('search') == '1')
                <li class="active">
                    <a href="#pb-all" data-toggle="tab"><i class="ti-panel"></i> Search Results</a>
                </li>
            @elseif ($user->is('teacher'))
                <li class="active">
                    <a href="#pb-all" data-toggle="tab"><i class="ti-panel"></i> Progress Bars Shared with Me</a>
                </li>
            @else
                @if($user->is('admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher'))
                <li class="active">
                    <a href="#pb-all" data-toggle="tab"><i class="ti-panel"></i> My Progress Bars</a>
                </li>
                @endif
            @endif
            <li>
                <a href="#pb-completed" data-toggle="tab"><i class="ti-check-box"></i> Completed Progress Bars</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content resources-container">
            <div class="tab-pane active in fade" id="pb-all">
                @if(count($progressBars) == 0)
                    <div class="panel">
                        <div class="panel-body">
                            <div class="alert alert-danger" style="margin-bottom: 0;">
                                <strong>Head's up!</strong> There are no Progress Bars here yet.
                            </div>
                            @if($user->is('admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher'))
                            <button class="btn btn-success btn-xs create-progress-bar" data-toggle="modal" data-target="#createProgressBarModal" title="Edit Progress Bar" type="button">Create Progress Bar</button>
                            @endif
                        </div>
                    </div>
                @else
                    {{--@include('partials/pb_list', ['progressBars' => $progressBars, 'pbStepProgress' => $pbStepProgress, 'pbCenterView' => true])--}}
                    @include('partials/pb_list', ['progressBars' => $progressBars, 'pbCenterView' => true])
                @endif
            </div>
            @if (!request('search'))
            <div class="tab-pane fade" id="pb-completed">
                @if(isSet($progressBarsCompleted) && count($progressBarsCompleted) == 0)
                    <div class="alert alert-danger" style="margin-bottom: 0;">
                        <strong> Head's up!</strong> There aren't any completed Progress Bars. Check back again soon.
                    </div>
                @else
                    @include('partials/pb_list', ['progressBars' => $progressBarsCompleted])
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- flip --->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/flip/js/jquery.flip.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/lcswitch/js/lc_switch.min.js"></script>
    <!--swiper-->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/swiper/js/swiper.min.js"></script>
    <!--nvd3 chart-->
    <script type="text/javascript" src="{{ app('request')->root() }}/js/nvd3/d3.v3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/nvd3/js/nv.d3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/moment/js/moment.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/advanced_newsTicker/js/newsTicker.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js/dashboard1.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/tabs_accordions.js"></script>
    <script src="{{ app('request')->root() }}/vendors/nestable-list/jquery.nestable.js"></script>
    <script src="{{ app('request')->root() }}/js/custom_js/nestable_list.js" type="text/javascript"></script>
    <!-- end of page level js -->
    @if (request('search') != '1')
        <script>
            $(".search-form").hide();
        </script>
    @endif
@endsection