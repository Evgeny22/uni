@extends('layouts.default')

@section('content')

    {{--@include('resources.popups')--}}

    <section class="resources component">

        {{--@include('resources.top')--}}

        <div class="row">
            <!--tab starts-->
            <!-- Nav tabs category -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tb-resource" data-toggle="tab"><i class="ti-package"></i> To be a Resource</a>
                </li>
                <li>
                    <a href="#tb-recovered" data-toggle="tab"><i class="ti-blackboard"></i> To be Recovered</a>
                </li>
                <li>
                    <a href="#tb-deleted" data-toggle="tab"><i class="ti-star"></i> To be Deleted</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content resources-container">
                <!-- To be a Resource -->
                <div class="tab-pane active in fade" id="tb-resource">
                    <div class="panel-body">
                        @if (count($pendingResource) == 0)
                            <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                <strong> Head's up!</strong> There are no items pending approval to become a Resource.
                            </div>
                        @else
                            <table class="table">
                                <tr>
                                    <td>Item Type</td>
                                    <td>Title</td>
                                    <td>Requested On</td>
                                    <td>Requested By</td>
                                    <td>Actions</td>
                                </tr>
                                @foreach ($pendingResource as $resource)
                                    <tr>
                                        <td>
                                            @if ($resource->exemplarable_type == 'App\LessonPlan')
                                                Lesson Plan
                                            @elseif ($resource->exemplarable_type == 'App\Video')
                                                Video
                                            @endif
                                        </td>
                                        <td>{{ $resource->exemplarable->title }}</td>
                                        <td>{{ $resource->created_at->diffForHumans() }}</td>
                                        <td>{{ $resource->author->displayName }}</td>
                                        <td>
                                            <button class="btn btn-success exemplar-request-approve">Approve</button>
                                            <button class="btn btn-danger exemplar-request-deny">Deny</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
                <!-- / To be a Resource -->

                <!-- To be Recovered -->
                <div class="tab-pane fade" id="tb-recovered">
                    <div class="panel-body">
                        <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                            <strong> Head's up!</strong> There are no items pending approval to be Recovered.
                        </div>
                    </div>
                </div>
                <!-- To be Recovered -->

                <!-- To be Deleted -->
                <div class="tab-pane fade" id="tb-deleted">
                    <div class="panel-body">
                        <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                            <strong> Head's up!</strong> There are no items pending approval to be Deleted.
                        </div>
                    </div>
                </div>
                <!-- To be Deleted -->
            </div>
            <!--tab ends-->
        </div>

    </section>

@endsection
