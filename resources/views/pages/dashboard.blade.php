@extends('layouts.default')

@section('content')

   {{-- @include('messages.popups')--}}

    <script>
        var progressBars = {!! $progressBars !!}
    </script>

    <section class="content">
        <div class="row">

            <div class="col-md-12 cover-wrapper">
                <!--<button type="button" class="btn btn-success btn-sm btn-cover" style="display: none;">Replace Image</button>-->
                <img class="img-responsive my-class cover-photo" src="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/img/dashboard-ph.jpg" />
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-agenda text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>Resources</b></p>
                            <p class="text-white">& Modules</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you will find protocols, readings, and other resources to support your knowledge of science, transfer to practice, and reflection.</p>
                            <p>
                                <a class="ladda-button btn btn-primary btn-sm button_normal"
                                   data-style="expand-left" href="{{ route ('resources') }}"><i class="ti-agenda text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-video-camera text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>Video</b></p>
                            <p class="text-white">Center</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you will find space to upload, annotate, analyze, and discuss your own video clips or clips others have shared with you.</p>
                            <p>
                                <a class="ladda-button btn btn-primary btn-sm button_normal"
                                   data-style="expand-left" href="{{ route ('video-center.index') }}"><i class="ti-video-camera text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            {{--<div class="col-sm-6 col-md-6 col-lg-4">--}}
                {{--<div class="flip">--}}
                    {{--<div class="widget-bg-color-icon bg-warning card-box front">--}}
                        {{--<div class="bg-icon pull-left">--}}
                            {{--<i class="ti-comments-smiley text-white"></i>--}}
                        {{--</div>--}}
                        {{--<div class="text-right">--}}
                            {{--<p class="text-white"><b>Discussion</b></p>--}}
                            {{--<p class="text-white">Board</p>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                    {{--<div class="widget-bg-color-icon bg-warning card-box back">--}}
                        {{--<div class="text-center">--}}
                            {{--<p class="text-white">Here you will be able to publicly communicate with others, including parents, teachers, master teachers, school directors, and members of the ESI team.</p>--}}
                            {{--<p>--}}
                                {{--<a class="ladda-button btn btn-primary button_normal btn-sm"--}}
                                   {{--data-style="expand-left" href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/forums"><i class="ti-comments-smiley text-white"></i> Visit Section--}}
                                {{--</a>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-comment-alt text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>Private</b></p>
                            <p class="text-white">Messages</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you can have private conversations. Only the selected participants can see these messages.</p>
                            <p>
                                <a class="ladda-button btn btn-primary button_normal btn-sm"
                                   data-style="expand-left" href="{{ route ('messages.index') }}"><i class="ti-comments-smiley text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-light-bulb text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>Instructional</b></p>
                            <p class="text-white">Design</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you can plan for high-quality science experiences, including templates and protocols for lesson planning, anticipatory planning webs, and space to reflect with others.
                            </p>
                            <p>
                                <a class="ladda-button btn btn-primary btn-sm button_normal"
                                   data-style="expand-left" href="{{ route ('instructional-design.index') }}"><i class="ti-light-bulb text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-pulse text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>My</b></p>
                            <p class="text-white">Activity</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you can get a quick summary of all the actions you've taken on the website.
                            </p>
                            <p>
                                <a class="ladda-button btn btn-primary btn-sm button_normal"
                                   data-style="expand-left" href="{{ route('activity',['id'=>$user->id]) }}"><i class="ti-pulse text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="flip">
                    <div class="widget-bg-color-icon bg-warning card-box front">
                        <div class="bg-icon pull-left">
                            <i class="ti-clipboard text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white"><b>My</b></p>
                            <p class="text-white">Plan</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="widget-bg-color-icon bg-warning card-box back">
                        <div class="text-center">
                            <p class="text-white">Here you can co-construct a professional development plan. Outline what you would like to do to support your knowledge of science and the transfer of that knowledge to your classroom, along with the specific supports you would like to receive from your Master teacher. You can create a progress bar to work toward a goal, and add other participants to each bar.</p>
                            <p>
                                <a class="ladda-button btn btn-primary btn-sm button_normal"
                                   data-style="expand-left" href="{{ route ('instructional-design.index') }}"><i class="ti-light-bulb text-white"></i> Visit Section
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript">
        $('.cover-wrapper').hover(
            function() {
                $( '.btn-cover' ).fadeIn( 500 );
            }, function() {
                $( '.btn-cover' ).fadeOut( 100 );
            }
        );
        $('.btn-cover').hover(
            function() {
                $( this ).show();
            }
        );
    </script>
    <!-- flip --->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/flip/js/jquery.flip.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/lcswitch/js/lc_switch.min.js"></script>
    <!--swiper-->
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/swiper/js/swiper.min.js"></script>
    <!--nvd3 chart-->
    <script type="text/javascript" src="{{ app('request')->root() }}/js/nvd3/d3.v3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/nvd3/js/nv.d3.min.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/moment/js/moment.min.js"></script>
    {{--<script type="text/javascript" src="{{ app('request')->root() }}/vendors/advanced_newsTicker/js/newsTicker.js"></script>--}}
    {{--<script type="text/javascript" src="{{ app('request')->root() }}/js/dashboard1.js"></script>--}}
    <script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/tabs_accordions.js"></script>
    <script src="{{ app('request')->root() }}/vendors/nestable-list/jquery.nestable.js"></script>
    <script src="{{ app('request')->root() }}/js/custom_js/nestable_list.js" type="text/javascript"></script>
    <!-- end of page level js -->
@endsection