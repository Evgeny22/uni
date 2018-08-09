<div class="row component-top">
    @if ($user->is('super_admin') or $user->is('mod') or $user->is('coach') or $user->is('teacher'))
        <button type="button" class="btn btn-sm btn-success btn-action upload-resource" data-trigger="new-post" data-private="0">Upload Resource</button>
        <button type="button" class="btn btn-sm btn-warning btn-action btn-search" data-action="search">Search</button>
        <!--<button type="button" class="btn btn-labeled btn-success btn-action upload-document" data-trigger="new-post" data-private="1">
            <span class="btn-label"><i class="ti-package"></i></span> Upload Private Document
        </button>-->
        <!--<button type="button" class="btn btn-labeled btn-primary btn-action" data-trigger="new-post">
            <span class="btn-label"><i class="ti-blackboard"></i></span> Add a New Learning Module
        </button>-->
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

{{--
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
                                <strong><small><i class="ti-calendar"></i> UPLOAD DATE</small></strong>
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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="select22" class="control-label">
                                <strong><small><i class="ti-package"></i> TYPE</small></strong>
                            </label>
                            <select id="select22" name="search_tags[]" class="form-control select2 tags" multiple="multiple" style="width:100%"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>--}}
