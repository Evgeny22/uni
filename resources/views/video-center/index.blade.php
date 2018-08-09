@extends('layouts.default')

@section('content')

@include('video-center.popups')
{!! $videos->render() !!}
<section class="video-center component">
    <div class="row component-top">
        @if($user->is('super_admin') or $user->is('mod') or $user->is('coach') or $user->is('master_teacher') or $user->is('teacher'))
        <button type="button" class="btn btn-sm btn-success btn-action upload-video" data-trigger="new-video">Upload Video</button>
        @endif
        <button type="button" class="btn btn-sm btn-warning btn-action btn-search" data-action="search">Search</button>
        {{--@if ($user->is('super_admin'))
            <a href="{{url("video-center/pending")}}" class="btn btn-danger btn-action">Pending Requests</a>
        @endif--}}
    </div>

    <div class="search-form">
        @include('partials/search_form', [
            'searchAction' => route('video-center.search'),
            'cancelAction' =>route('video-center.index'),
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
                    <a href="#videos-all" data-toggle="tab"><i class="ti-video-camera"></i> Search Results</a>
                </li>
            @else
                <li class="active">
                    <a href="#videos-all" data-toggle="tab"><i class="ti-video-camera"></i> My Videos</a>
                </li>
                <li>
                    <a href="#videos-shared" data-toggle="tab"><i class="ti-gift"></i> Videos Shared with Me</a>
                </li>
                {{--Hidden--}}
                <li>
                    <a href="#videos-saved" data-toggle="tab"><i class="ti-star"></i> Bookmarked Videos</a>
                </li>
            @endif
        </ul>

        <!-- Tab panes -->
        <div class="tab-content resources-container">
            <div class="tab-pane active in fade" id="videos-all">
                <div>
                    @if(count($videos) == 0)
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong>
                                            Head's up!
                                        </strong>&nbsp;
                                            @if (request('search'))
                                                No videos were found with your search criteria.
                                            @else
                                                You haven't uploaded any videos yet. Check the "Videos Shared With Me" tab to see if anyone has tagged you in a video!
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('partials/video_list', ['videos' => $videos])
                    @endif
                </div>
            </div>
            @if (!request('search'))
                {{--Hidden--}}
                <div class="tab-pane" id="videos-saved">
                    @if(count($savedVideos) == 0)
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="alert-message alert-message-danger">
                                        <h4>
                                            Head's up!
                                        </h4>
                                        <p>
                                            You haven't bookmarked any videos yet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('partials/video_list', ['videos' => $savedVideos])
                    @endif
                </div>
                <div class="tab-pane" id="videos-shared">
                    @if(count($sharedVideos) == 0)
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong>
                                            Head's up!
                                        </strong>&nbsp;
                                        You haven't had any videos shared with you. Check back again soon.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('partials/video_list', ['videos' => $sharedVideos])
                    @endif
                </div>
            @endif

            <div class="row">
                {{ $videos->appends([
                    'search_tags' => request('search_tags'),
                    'year' => request('year'),
                    'month' => request('month'),
                    'day' => request('day'),
                    'author' => request('author'),
                    'title' => request('title'),
                    'search' => request('search')
                ])->links() }}
            </div>
        </div>
    </div>

</section>
<script src="{{ app('request')->root() }}/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script src="{{ app('request')->root() }}/js/custom_js/pickers.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/js/custom_js/tabs_accordions.js"></script>
<script type="text/javascript" src="{{ app('request')->root() }}/vendors/toolbar/js/jquery.toolbar.min.js"></script>
{{--<!-- date-range-picker -->--}}
{{--<script src="{{ app('request')->root() }}/vendors/daterangepicker/js/daterangepicker.js" type="text/javascript"></script>--}}
{{--<!-- bootstrap time picker -->--}}
{{--<script src="{{ app('request')->root() }}/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>--}}
{{--<script src="{{ app('request')->root() }}/vendors/clockpicker/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>--}}
{{--<script src="{{ app('request')->root() }}/vendors/jquerydaterangepicker/js/jquery.daterangepicker.min.js" type="text/javascript"></script>--}}
{{--<script src="{{ app('request')->root() }}/js/custom_js/datepickers.js" type="text/javascript"></script>--}}
@if (request('search') != '1')
    <script>
        $(".search-form").hide();
    </script>
@endif

@endsection
