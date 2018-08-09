<div class="search-form">

<div class="row">
    <div class="well" style="overflow: auto;">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-2 control-label" style="margin: 0 -100px 0 -30px; color: #a0a0a0;"><small>SEARCH</small></label>
                <div class="col-sm-10">
                    <form method="GET" action="{{ $searchAction }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="search" value="1" />
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search_title" class="control-label">
                                    <strong><small>TITLE &amp; DESCRIPTION</small></strong>
                                </label>
                                <div class="input-group">
                                    <input class="form-control" id="search_title" type="text" name="title" value="{{ request('title') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search_author" class="control-label">
                                    <strong><small>AUTHOR</small></strong>
                                </label>
                                {{--@if ($user->is('super_admin'))--}}
                                    <select id="select22" name="author[]" class="form-control select2 search-by-author" multiple="multiple">
                                        @if (!empty($prefilled['author']))
                                            @foreach ($prefilled['author'] as $selectedAuthor)
                                                <option value="{{ $selectedAuthor['id'] }}" selected="selected">{{ $selectedAuthor['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                {{--@else
                                    <div class="input-group">
                                        <input class="form-control" id="author" type="text" name="author" value="{{ request('author') }}" />
                                    </div>
                                @endif--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select22" class="control-label">
                                    <strong><small><i class="ti-calendar"></i> DATE UPLOADED</small></strong>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                @if($hideTags == false)
                                    <label for="select22" class="control-label">
                                        <strong><small><i class="ti-tag"></i> TAG</small></strong>
                                    </label>
                                    <select id="select22" name="search_tags[]" class="form-control select2 tags" multiple="multiple" style="width:100%">
                                        @if (!empty($prefilled['tags']))
                                            @foreach ($prefilled['tags'] as $tag)
                                                <option value="{{ $tag['id'] }}" selected="selected">{{ $tag['tag'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm btn-action">Search</button>
                            @if(request('search'))
                                <button class="btn btn-danger btn-sm btn-action cancel-redirect" data-redirect="{{ $cancelAction }}#showSearchForm">Clear All Filters</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>