@extends('layouts.default')

@section('content')

@include('progress-bars/popups', ['progressBarTemplates' => $progressBarTemplates])

    <div class="row">
        @include('partials/pb_list', ['progressBars' => $progressBars, 'pbStepProgress' => $pbStepProgress, 'singleView' => true])
    </div>

    @if (request('edit') == '1')
    <script>
        $(".edit-progress-bar").trigger( "click" );
    </script>
    @endif

    <!-- flip --->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/flip/js/jquery.flip.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/lcswitch/js/lc_switch.min.js"></script>
    <!--swiper-->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/swiper/js/swiper.min.js"></script>
    <!--nvd3 chart-->
    <script type="text/javascript" src="{{ app('request')->root() }}/js/nvd3/d3.v3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/nvd3/js/nv.d3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/moment/js/moment.min.js"></script>
    {{--<script type="text/javascript" src="{{ app('request')->root() }}/vendors/advanced_newsTicker/js/newsTicker.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js/dashboard1.js"></script>--}}
    <script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/tabs_accordions.js"></script>
    <script src="{{ app('request')->root() }}/vendors/nestable-list/jquery.nestable.js"></script>
    <script src="{{ app('request')->root() }}/js/custom_js/nestable_list.js" type="text/javascript"></script>
    <!-- end of page level js -->
@endsection