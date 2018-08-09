@extends('layouts.default')

@section('content')

    @include('resources.popups')

    <section class="resources component">

        @include('resources.top')

        @include('partials/search_form', [
            'searchAction' => route('resources.search'),
            'cancelAction' =>route('resources'),
            'hideTags' => true,
            'prefilled' => isSet($prefilled) ? $prefilled : null
        ])

        <div class="row">
            <!--tab starts-->
            <!-- Nav tabs category -->
            <ul class="nav nav-tabs">
                @if (request('search') == '1')
                    <li class="active">
                        <a href="#search-results" data-toggle="tab"><i class="ti-video-camera"></i> Search Results</a>
                    </li>
                @else
                    <li class="active">
                        <a href="#resources-all" data-toggle="tab"><i class="ti-package"></i> Public Docs &amp; Links</a>
                    </li>
                    <li>
                        <a href="#resources-private" data-toggle="tab"><i class="ti-blackboard"></i> My Docs &amp; Links</a>
                    </li>
                    <li>
                        <a href="#resources-saved" data-toggle="tab"><i class="ti-star"></i> Bookmarked Resources</a>
                    </li>
                    <li>
                        <a href="#resources-shared" data-toggle="tab"><i class="ti-gift"></i> Shared With Me</a>
                    </li>
                @endif
            </ul>
            <!-- Tab panes -->
            <div class="tab-content resources-container">
                @if (request('search') == '1')
                    <!-- Search Results -->
                        <div class="tab-pane active in fade" id="search-results">
                            <div class="panel-group" id="accordion-cat-1">
                                @if(count($resources) > 0)
                                    @include('partials/resource_list', ['resources' => $resources])
                                @else
                                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                        <strong> Head's up!</strong> No resources were found with your search criteria.
                                    </div>
                                @endif
                            </div>
                        </div>
                    <!-- / Search Results -->
                @else
                    <!-- Public Resources -->
                    <div class="tab-pane active in fade" id="resources-all">
                        <div class="panel-group" id="accordion-cat-1">
                            @if(count($resources) > 0)
                                @include('partials/resource_list', ['resources' => $resources])
                            @else
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Resources here yet.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- / Public Resources -->

                    <!-- Private Documents -->
                    <div class="tab-pane fade" id="resources-private">
                        <div class="panel-group" id="accordion-cat-2">
                            @if(count($privateDocuments) > 0)
                                @include('partials/resource_list', ['resources' => $privateDocuments])
                            @else
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Private Documents here yet.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- / Shared Resources -->

                    <!-- Shared With Me Resources -->
                    <div class="tab-pane fade" id="resources-shared">
                        <div class="panel-group" id="accordion-cat-3">
                            @if(count($sharedWithMeResources) > 0)
                                @include('partials/resource_list', ['resources' => $sharedWithMeResources])
                            @else
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> You don't have any Resources share with you.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- / Shared With Me Resources -->

                    <!-- Saved Resources -->
                    <div class="tab-pane fade" id="resources-saved">
                        <div class="panel-group" id="accordion-cat-3">
                            @if(count($privateDocuments) > 0)
                                @include('partials/resource_list', ['resources' => $savedResources])
                            @else
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> You haven't saved any Resource yet.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- / Saved Resources -->
                @endif
            </div>
            <!--tab ends-->
        </div>

    </section>
    @if (request('search') != '1')
        <script>
            $(".search-form").hide();
        </script>
    @endif
    <script>
        $('#document').on('change', function () {
            if ($('#document').get(0).files.length !== 0) {
                $('select[name="resource_type_id"]').val('10');
                $('select[name="resource_type_id"]').prop('disabled', 'disabled');
            } else {
                $('select[name="resource_type_id"]').prop('selectedIndex', 0);
                $('select[name="resource_type_id"]').prop('disabled', false);
            }
        });
        $('select[name="resource_type_id"]').on('change', function () {
            if ( $(this).val() == '10' ) {
                $('.change-document').show();
                $('.link-field').hide();
            } else if ( $(this).val() == '0') {
                $('.change-document').hide();
            } else {
                $('.change-document').hide();
                $('.link-field').show();
            }
        });
    </script>
@endsection
