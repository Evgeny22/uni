<div class="row component-top">
    @if ( $user->is('super_admin'))
        <button type="button" class="btn btn-labeled btn-success btn-action" data-trigger="new-post">
                                                <span class="btn-label">
                                                <i class="ti-upload"></i>
                                            </span> Create New
        </button>
        <a href="{{url("instructional-design/exemplars")}}" class="btn btn-labeled btn-danger btn-action">
                                                <span class="btn-label">
                                                <i class="ti-star"></i>
                                            </span> Pending Exemplar Requests
        </a>
    @endif
    {{--<div class="options">--}}

    {{--@if ($page == 'resources_category')--}}
    {{--<div class="sort">--}}

    {{--<h3><a href="#">@if (app('request')->input('sort') == 'asc') Oldest First @else Most Recent @endif<i class="icon icon-open-dd"></i></a></h3>--}}

    {{--</div>--}}

    {{--@endif--}}

    {{--<div class="search">--}}

    {{--<select name="search-by-title-and-author" class="search-by"><option></option></select>--}}

    {{--</div>--}}
    {{----}}
    {{--</div>--}}

</div>

<div class="row">
    <div class="well" style="overflow: auto;">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-2 control-label" style="margin: 0 -100px 0 -30px; color: #a0a0a0;"><small>FILTERS</small></label>
                <div class="col-sm-10">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="select22" class="control-label">
                                <strong><small><i class="ti-search"></i> AUTHOR or TITLE</small></strong>
                            </label>
                            <select id="select22" name="search-by-title-and-author" class="form-control select2" multiple="multiple" tyle="width:100%"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="select22" class="control-label">
                                <strong><small><i class="ti-calendar"></i> CREATE DATE</small></strong>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="reservation"
                                       placeholder="MM/DD/YYYY - MM/DD/YYYY"/>
                            </div>
                            <!-- /.input group -->
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="select22" class="control-label">
                                <strong><small><i class="ti-tag"></i> TAG</small></strong>
                            </label>
                            <select id="select22" name="search_tags[]" class="form-control select2 tags" multiple="multiple" style="width:100%"></select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="row component-top">--}}

    {{--<div class="button">--}}

        {{--<a href="#" class="btn btn-action" data-trigger="new-post">Create a New Lesson Plan +</a>--}}

    {{--</div>--}}

    {{--<div class="options">--}}

        {{--@if ($page == 'instructional-design')--}}

        {{--<div class="sort">--}}

            {{--<h3><a href="#">@if (app('request')->input('sort') == 'exemplar') Exemplar @elseif (app('request')->input('sort') == 'asc') Oldest First @else Most Recent @endif<i class="icon icon-open-dd"></i></a></h3>--}}

        {{--</div>--}}

        {{--@else--}}
        {{--<div class="go-back">--}}

            {{--<h3><a href="{{ route ('instructional-design.index') }}">&lt; Back To ID's</a></h3>--}}

        {{--</div>--}}
        {{--@endif--}}

        {{--<div class="search-by-tag">--}}

            {{--<select name="search_tags[]" class="tags" multiple="multiple"></select>--}}
            {{--<i class="icon icon-search" id="search-tags"></i>--}}

        {{--</div>--}}

        {{--<div class="search">--}}

            {{--<select name="search-by-title-and-author" class="search-by"><option></option></select>--}}

        {{--</div>--}}

    {{--</div>--}}

{{--</div>--}}