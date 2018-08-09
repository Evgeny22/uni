@extends('layouts.default')

@section('content')

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
                        @if (count($pendingResources) == 0)
                            <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                <strong> Head's up!</strong> There are no items pending approval to become a Resource.
                            </div>
                        @else
                            <table class="table">
                                <tr>
                                    <td>Title</td>
                                    <td>Requested On</td>
                                    <td>Requested By</td>
                                    <td>Actions</td>
                                </tr>
                                @foreach ($pendingResources as $resource)
                                    <tr>
                                        <td>{{ $resource->exemplarable->title }}</td>
                                        <td>{{ $resource->created_at->diffForHumans() }}</td>
                                        <td>{{ $resource->author->displayName }}</td>
                                        <td>
                                            <a href="{{ route('video-center.show', [
                                                'id' => $resource->exemplarable_id,
                                                'pendingMode' => true,
                                                'pendingId' => 0
                                            ])}}"><button class="btn btn-primary">View</button></a>
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
                        @if (count($pendingRecovered) == 0)
                            <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                <strong> Head's up!</strong> There are no items pending approval to be Recovered.
                            </div>
                        @else
                            <table class="table">
                                <tr>
                                    <td>Title</td>
                                    <td>Requested On</td>
                                    <td>Requested By</td>
                                    <td>Actions</td>
                                </tr>
                                @foreach ($pendingRecovered as $recover)
                                    <tr>
                                        <td>{{ $recover->video->title }}</td>
                                        <td>{{ $recover->created_at->diffForHumans() }}</td>
                                        <td>{{ $recover->video->author->displayName }}</td>
                                        <td>
                                            <a href="{{ route('video-center.show', [
                                                'id' => $recover->video->id,
                                                'recoverMode' => true,
                                                'recoverId' => $recover->id
                                            ])}}"><button class="btn btn-primary">View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
                <!-- To be Recovered -->

                <!-- To be Deleted -->
                <div class="tab-pane fade" id="tb-deleted">
                    <div class="panel-body">
                        @if (count($pendingDeleted) == 0)
                            <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                <strong> Head's up!</strong> There are no items pending approval to be Deleted.
                            </div>
                        @else
                            <table class="table">
                                <tr>
                                    <td>Title</td>
                                    <td>Requested On</td>
                                    <td>Requested By</td>
                                    <td>Actions</td>
                                </tr>
                                @foreach ($pendingDeleted as $delete)
                                    <tr>
                                        <td>{{ $delete->video->title }}</td>
                                        <td>{{ $delete->created_at->diffForHumans() }}</td>
                                        <td>{{ $delete->video->author->displayName }}</td>
                                        <td>
                                            <a href="{{ route('video-center.show', [
                                                'id' => $delete->video->id,
                                                'deleteMode' => true,
                                                'deleteId' => $delete->id
                                            ])}}"><button class="btn btn-primary">View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
                <!-- To be Deleted -->
            </div>
            <!--tab ends-->
        </div>

    </section>

@endsection
