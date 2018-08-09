@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="well" style="overflow: auto;">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-2 control-label" style="margin: 0 -100px 0 -30px; color: #a0a0a0;"><small>FILTER</small></label>
                    <div class="col-sm-10">
                        <form method="get" action="{{ route('notifications.index') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="search" value="1" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search_author" class="control-label">
                                        <strong><small>TYPE</small></strong>
                                    </label>
                                    {{--<select id="select22" name="search-by-author" class="form-control select2" multiple="multiple" style="width:100%"></select>--}}
                                    {{--<input id="search_author" type="text" name="author" value="{{ request('author') }}" />--}}
                                    <div class="input-group">
                                        <select name="type">
                                            <option value="">Type</option>
                                            <option value="video-center">Video Center</option>
                                            <option value="message-board">Message Board</option>
                                            <option value="lesson-plans">Lesson Plans</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="select22" class="control-label">
                                        <strong><small><i class="ti-calendar"></i> DATE</small></strong>
                                    </label>

                                    <div class="input-group">
                                        <?php
                                        $thisYear = date('Y');
                                        $earliestYear = $thisYear - 3;
                                        $latestYear = $thisYear;
                                        $months = [
                                            '1' => 'January',
                                            '2' => 'February',
                                            '3' => 'March',
                                            '4' => 'April',
                                            '5' => 'May',
                                            '6' => 'June',
                                            '7' => 'July',
                                            '8' => 'August',
                                            '9' => 'September',
                                            '10' => 'October',
                                            '11' => 'November',
                                            '12' => 'December'
                                        ]
                                        ?>
                                        <select class="form-control select-group" name="month">
                                            <option value="">Month</option>
                                            @foreach ($months as $monthId => $monthName)
                                                <option value='{{ $monthId }}'
                                                        @if (request('month') == $monthId)
                                                        selected
                                                        @endif
                                                >{{ $monthName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control select-group" name="day">
                                            <option value="">Day</option>
                                            @for ($day = 1; $day < 32; $day++)
                                                <option value="{{ $day }}"
                                                        @if (request('day') == $day)
                                                        selected
                                                        @endif
                                                >{{ $day }}</option>
                                            @endfor
                                        </select>
                                            <select class="form-control select-group" name="year">
                                                <option value="">Year</option>
                                                <?php for ($year = $earliestYear; $year <= $latestYear; $year++): ?>
                                                <option value="<?php echo $year; ?>"
                                                        @if (request('year') == $year)
                                                        selected
                                                        @endif
                                                ><?php echo $year; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm btn-action">Search</button>
                                @if(request('search'))
                                    <button class="btn btn-danger btn-sm btn-action cancel-redirect" data-redirect="{{ route('notifications.index') }}">Clear All Filters</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <article class="full" id="activity">

        {{--<h3 class="float-right space-bottom"><a href="{{ route('profile', ['id' => $user->id ]) }}">&lt; View Your Profile</a></h3>--}}

        {{--<h3><i class="icon icon-list"></i> Activity</h3>--}}

        <div class="panel ">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="ti-pulse"></i>
                    Notifications
                </h3>
            </div>
            <div class="panel-body">
                <ul class="schedule-cont">
                    @if ($notifications->count())
                        @foreach ($notifications as $notification)
                            {!! $notification->render() !!}
                        @endforeach
                    @else
                        <li>No notifications.</li>
                    @endif
                </ul>
            </div>
        </div>

    </article>

    {!! $notifications->render() !!}

@endsection
