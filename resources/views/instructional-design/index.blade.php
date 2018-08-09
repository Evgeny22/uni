@extends('layouts.default')

@section('content')

@include('instructional-design.popups')

{{--@if ($user->is('super_admin'))--}}

    {{--<h3 class="float-right space-bottom"><a href="{{url("instructional-design/exemplars")}}"><i class="icon icon-exemplar"></i> Pending Exemplar Requests</a></h3>--}}

{{--@endif--}}

<section class="instructional-design component">

    @include('instructional-design.top')

        {{--{!! strlen($resultFor) > 0 ? '<h3><i class="icon icon-tags"></i>' . $resultFor . '</h3><p></p>': ''  !!}--}}

        {{--<article class="module full">--}}

            {{--<h2 class="id-bg">Instructional Design Lesson Plans</h2>--}}

            {{--<div class="module-content pad-wide">--}}

                {{--@if(count($lessonPlans)>0)--}}
                    {{--@include('lesson_plans_list')--}}
                {{--@else--}}
                    {{--<h3> There aren't Instructional Design Lesson Plans.</h3>--}}
                {{--@endif--}}

            {{--</div>--}}

        {{--</article>--}}

        <div class="row">
            <!--tab starts-->
            <!-- Nav tabs category -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#instructional-all" data-toggle="tab"><i class="ti-blackboard"></i> Lesson Plans</a>
                </li>
                <li class="pull-right">
                    <a href="#instructional-mine" data-toggle="tab"><i class="ti-light-bulb"></i> My Instructional Designs</a>
                </li>
                <li class="pull-right">
                    <a href="#instructional-saved" data-toggle="tab"><i class="ti-star"></i> Saved</a>
                </li>
                <li class="pull-right">
                    <a href="#instructional-shared" data-toggle="tab"><i class="ti-gift"></i> Shared</a>
                </li>


            </ul>
            <!-- Tab panes -->
            <div class="tab-content resources-container">
                <div class="tab-pane active in fade" id="instructional-all">
                    @if(count($lessonPlans)>0)
                        @include('lesson_plans_list')
                    @else
                        <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                            <strong> Head's up!</strong> There are no Instructional Designs here yet. Check back again soon.
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="instructional-mine">
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> There are no Instructional Designs here yet. Check back again soon.
                    </div>
                </div>
                <div class="tab-pane fade" id="instructional-shared">
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> There are no Instructional Designs here yet. Check back again soon.
                    </div>
                </div>
                <div class="tab-pane fade" id="instructional-saved">
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> There are no Instructional Designs here yet. Check back again soon.
                    </div>
                </div>

            </div>
            <!--tab ends-->
        </div>

        {!! $lessonPlans->render() !!}


</section>

@endsection

