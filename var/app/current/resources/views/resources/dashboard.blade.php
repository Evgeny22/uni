@extends('layouts.default')

@section('content')

@include('resources.popups')

<section class="resources component">

    @include('resources.top')

    {{--@for($i=0;$i<count($resource_types)-2;$i+=3)--}}

        {{--<article class="module resource-type">--}}

            {{--<h2 class=""><i class="icon icon-{{ str_replace(" ", "-", $resource_types[$i]['category']) }}"></i> For {{ $resource_types[$i]['category'] }}</h2>--}}

            {{--<div class="module-content">--}}

                {{--<ul>--}}
                    {{--<li><a href="{{url('resources/'.str_replace(' ','-',$resource_types[$i]['category']).'/'.$resource_types[$i]['type'])}}">Infants (Ages 0-1)</a> </li>--}}
                    {{--<li><a href="{{url('resources/'.str_replace(' ','-',$resource_types[$i+1]['category']).'/'.$resource_types[$i+1]['type'])}}">Toddlers (Ages 1-3)</a> </li>--}}
                    {{--<li><a href="{{url('resources/'.str_replace(' ','-',$resource_types[$i+2]['category']).'/'.$resource_types[$i+2]['type'])}}">Preschoolers (Ages 3-5)</a> </li>--}}
                {{--</ul>--}}

            {{--</div>--}}

        {{--</article>--}}

    {{--@endfor--}}

    <div class="row">
        <!--tab starts-->
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#resources-all" data-toggle="tab"><i class="ti-package"></i> Resources</a>
            </li>
            <li>
                <a href="#modules" data-toggle="tab"><i class="ti-blackboard"></i> Modules</a>
            </li>
            <li class="pull-right">
                <a href="#resources-saved" data-toggle="tab"><i class="ti-star"></i> Saved</a>
            </li>
            <li class="pull-right">
                <a href="#resources-shared" data-toggle="tab"><i class="ti-gift"></i> Shared</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content resources-container">
            <!-- Resources -->
            <div class="tab-pane active in fade" id="resources-all">
                <div class="panel-group" id="accordion-cat-1">
                    <!-- Resource Readings -->
                    <div class="panel panel-warning panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-1"
                               href="#resources-all-readings">
                                <h4 class="panel-title">
                                    <i class="ti-book"></i> Readings
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-all-readings" class="panel-collapse collapse">
                            <div class="panel" style="margin: 25px;">
                                <div class="panel-heading" style="overflow: auto;">
                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                        <a href="#">Resource Title</a>
                                    </h3>
                                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                                <div class="img">
                                                    <a href="#"><span class="profile-pic"><img src="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/avatars/original/missing.jpg" alt="Author"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="details">
                                                    <div class="name">
                                                        <small><a href="#">Author Name</a></small>
                                                    </div>
                                                    <div class="time">
                                                        <small><i class="ti-time"></i>
                                                            <span data-class="date-time">3 days ago</span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IF VIDEO -->
                                    <a href="#" class="btn-label label-right btn-success pull-right">
                                        <span class="text-white">00:25 <i class="ti-timer"></i></span>
                                    </a>
                                    <!-- ENDIF -->
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 bord">
                                        <div class="row">
                                            <!-- IF VIDEO -->
                                            <div class="col-md-6">
                                                <div class="img">
                                                    <a href="#">
                                                        <img class="media-object thumbnail img-responsive" src="http://via.placeholder.com/800x450" alt="avatar image">
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- ENDIF -->
                                            <div class="col-md-6">
                                                <p class="description">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.

                                                    Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.

                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>

                                                <div class="btn-group" role="group" aria-label="Video actions">
                                                    <a class="btn btn-success" href="#"><i class="ti-agenda"></i> Open</a>
                                                    <a class="btn btn-primary" href="#"><i class="ti-gift"></i> Share</a>
                                                    <a class="btn btn-warning" href="#"><i class="ti-star"></i> Save</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <!-- IF ADMIN -->
                                        <span class="post-modifications">
                                                <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                                                <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>
                                        </span>
                                    <!-- ENDIF -->

                                        <div class="panel-group" id="resource-tag-ID">
                                                <div class="panel panel-primary panel-faq">
                                                    <div class="panel-heading">
                                                        <a data-toggle="collapse" data-parent="#resource-tag-ID" href="#tags-resource-ID" class="collapsed" aria-expanded="false">
                                                            <h4 class="panel-title text-white">
                                                                <i class="ti-tag"></i> Tags
                                                                <span class="pull-right"></span>
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div id="tags-resource-ID" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <div class="well">
                                                                <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Using+Math+and+Computational+Thinking" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                                    <small>Using Math and Computational Thinking</small>
                                                                </a>
                                                                <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Physical+Science" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                                    <small>Physical Science</small>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Resource Readings -->

                    <!-- Resource Links -->
                    <div class="panel panel-primary panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-1"
                               href="#resources-all-links" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-link"></i> Links
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-all-links" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Links here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Resource Links -->

                    <!-- Resource Videos -->
                    <div class="panel panel-success panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-1"
                               href="#resources-all-videos" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-video-camera"></i> Videos
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-all-videos" class="panel-collapse collapse">
                            <div class="panel-body">
                                @if (count($resources) > 0)
                                    @foreach($resources as $resource)
                                        @if ($resource->type->id == '11')
                                            <div class="row">
                                                <div class="panel-heading" style="overflow: auto;">
                                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                                        <a href="{{ $resource->link }}">{{ $resource->name }}</a>
                                                    </h3>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                        <strong> Head's up!</strong> There are no Resources here yet. Check back again soon.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- / Videos -->
                </div>
            </div>
            <!-- / Resources -->

            <!-- Shared Resources -->
            <div class="tab-pane fade" id="resources-shared">
                <div class="panel-group" id="accordion-cat-2">
                    <!-- Shared Readings -->
                    <div class="panel panel-warning panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-2"
                               href="#resources-shared-readings">
                                <h4 class="panel-title">
                                    <i class="ti-book"></i> Readings
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-shared-readings" class="panel-collapse collapse">
                            <div class="panel" style="margin: 25px;">
                                <div class="panel-heading" style="overflow: auto;">
                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                        <a href="#">Resource Title</a>
                                    </h3>
                                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                                <div class="img">
                                                    <a href="#"><span class="profile-pic"><img src="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/avatars/original/missing.jpg" alt="Author"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="details">
                                                    <div class="name">
                                                        <small><a href="#">Author Name</a></small>
                                                    </div>
                                                    <div class="time">
                                                        <small><i class="ti-time"></i>
                                                            <span data-class="date-time">3 days ago</span></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IF VIDEO -->
                                    <a href="#" class="btn-label label-right btn-success pull-right">
                                        <span class="text-white">00:25 <i class="ti-timer"></i></span>
                                    </a>
                                    <!-- ENDIF -->
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 bord">
                                        <div class="row">
                                            <!-- IF VIDEO -->
                                            <div class="col-md-6">
                                                <div class="img">
                                                    <a href="#">
                                                        <img class="media-object thumbnail img-responsive" src="http://via.placeholder.com/800x450" alt="avatar image">
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- ENDIF -->
                                            <div class="col-md-6">
                                                <p class="description">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.

                                                    Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.

                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                <a href="#" class="btn btn-labeled btn-success">
                                        <span class="btn-label">
                                                <i class="ti-agenda"></i>
                                            </span> View Resource
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <!-- IF ADMIN -->
                                        <span class="post-modifications">


                                                <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                                                <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                        </span>

                                    <!-- ENDIF -->


                                    <div class="panel-group" id="resource-tag-ID">
                                        <div class="panel panel-primary panel-faq">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#resource-tag-ID" href="#tags-resource-ID" class="collapsed" aria-expanded="false">
                                                    <h4 class="panel-title text-white">
                                                        <i class="ti-tag"></i> Tags
                                                        <span class="pull-right"></span>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="tags-resource-ID" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div class="well">


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Using+Math+and+Computational+Thinking" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Using Math and Computational Thinking</small>
                                                        </a>


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Physical+Science" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Physical Science</small>
                                                        </a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Shared Readings -->

                    <!-- Shared Links -->
                    <div class="panel panel-primary panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-2"
                               href="#resources-shared-links" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-link"></i> Links
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-shared-links" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Links here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Shared Links  -->

                    <!-- Shared Videos -->
                    <div class="panel panel-success panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-2"
                               href="#resources-shared-videos" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-video-camera"></i> Videos
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-shared-videos" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Videos here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Shared Videos -->
                </div>
            </div>
            <!-- / Shared Resources -->

            <!-- Saved Resources -->
            <div class="tab-pane fade" id="resources-saved">
                <div class="panel-group" id="accordion-cat-3">
                    <!-- Saved Readings -->
                    <div class="panel panel-warning panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-3"
                               href="#resources-saved-readings">
                                <h4 class="panel-title">
                                    <i class="ti-book"></i> Readings
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-saved-readings" class="panel-collapse collapse">
                            <div class="panel" style="margin: 25px;">
                                <div class="panel-heading" style="overflow: auto;">
                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                        <a href="#">Resource Title</a>
                                    </h3>
                                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                                <div class="img">
                                                    <a href="#"><span class="profile-pic"><img src="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/avatars/original/missing.jpg" alt="Author"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="details">
                                                    <div class="name">
                                                        <small><a href="#">Author Name</a></small>
                                                    </div>
                                                    <div class="time">
                                                        </small><i class="ti-time"></i> <span data-class="date-time">

                        3 days ago

                    </span></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IF VIDEO -->
                                    <a href="#" class="btn-label label-right btn-success pull-right">
                                        <span class="text-white">00:25 <i class="ti-timer"></i></span>
                                    </a>
                                    <!-- ENDIF -->
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 bord">
                                        <div class="row">
                                            <!-- IF VIDEO -->
                                            <div class="col-md-6">
                                                <div class="img">
                                                    <a href="#">
                                                        <img class="media-object thumbnail img-responsive" src="http://via.placeholder.com/800x450" alt="avatar image">
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- ENDIF -->
                                            <div class="col-md-6">
                                                <p class="description">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.

                                                    Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.

                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                <a href="#" class="btn btn-labeled btn-success">
                                        <span class="btn-label">
                                                <i class="ti-agenda"></i>
                                            </span> View Resource
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <!-- IF ADMIN -->
                                        <span class="post-modifications">


                                                <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                                                <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                        </span>

                                    <!-- ENDIF -->


                                    <div class="panel-group" id="resource-tag-ID">
                                        <div class="panel panel-primary panel-faq">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#resource-tag-ID" href="#tags-resource-ID" class="collapsed" aria-expanded="false">
                                                    <h4 class="panel-title text-white">
                                                        <i class="ti-tag"></i> Tags
                                                        <span class="pull-right"></span>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="tags-resource-ID" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div class="well">


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Using+Math+and+Computational+Thinking" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Using Math and Computational Thinking</small>
                                                        </a>


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Physical+Science" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Physical Science</small>
                                                        </a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Saved Readings -->

                    <!-- Links -->
                    <div class="panel panel-primary panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-3"
                               href="#resources-saved-links" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-link"></i> Links
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-saved-links" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Resources here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Links -->

                    <!-- Videos -->
                    <div class="panel panel-success panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-3"
                               href="#resources-saved-videos" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-video-camera"></i> Videos
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-saved-videos" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Videos here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Videos -->
                </div>
            </div>
            <!-- / Saved Resources -->

            <!-- Modules -->
            <div class="tab-pane fade" id="modules">
                <div class="panel-group" id="accordion-cat-4">
                    <!-- Module Readings -->
                    <div class="panel panel-warning panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-4"
                               href="#resources-modules-readings">
                                <h4 class="panel-title">
                                    <i class="ti-book"></i> Readings
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-modules-readings" class="panel-collapse collapse">
                            <div class="panel" style="margin: 25px;">
                                <div class="panel-heading" style="overflow: auto;">
                                    <h3 class="panel-title" style="font-size: 26px; margin-bottom: 4px;">
                                        <a href="#">Resource Title</a>
                                    </h3>
                                    <div class="col-md-6 col-lg-6 col-sm-6 bord">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left:-15px;"> <small><strong>POSTED BY</strong></small></div>
                                            <div class="col-md-2" style="margin-left:-15px;margin-right:-35px;">
                                                <div class="img">
                                                    <a href="#"><span class="profile-pic"><img src="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/avatars/original/missing.jpg" alt="Author"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="details">
                                                    <div class="name">
                                                        <small><a href="#">Author Name</a></small>
                                                    </div>
                                                    <div class="time">
                                                        </small><i class="ti-time"></i> <span data-class="date-time">

                        3 days ago

                    </span></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IF VIDEO -->
                                    <a href="#" class="btn-label label-right btn-success pull-right">
                                        <span class="text-white">00:25 <i class="ti-timer"></i></span>
                                    </a>
                                    <!-- ENDIF -->
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 bord">
                                        <div class="row">
                                            <!-- IF VIDEO -->
                                            <div class="col-md-6">
                                                <div class="img">
                                                    <a href="#">
                                                        <img class="media-object thumbnail img-responsive" src="http://via.placeholder.com/800x450" alt="avatar image">
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- ENDIF -->
                                            <div class="col-md-6">
                                                <p class="description">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.

                                                    Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.

                                                    Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                <a href="#" class="btn btn-labeled btn-success">
                                        <span class="btn-label">
                                                <i class="ti-agenda"></i>
                                            </span> View Resource
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <!-- IF ADMIN -->
                                        <span class="post-modifications">


                                                <i class="icon icon-edit" title="Edit Video Post" data-trigger="edit-post"></i>
                                                <i class="icon icon-remove" title="Remove Video Post" data-trigger="remove-post"></i>

                        </span>

                                    <!-- ENDIF -->


                                    <div class="panel-group" id="resource-tag-ID">
                                        <div class="panel panel-primary panel-faq">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#resource-tag-ID" href="#tags-resource-ID" class="collapsed" aria-expanded="false">
                                                    <h4 class="panel-title text-white">
                                                        <i class="ti-tag"></i> Tags
                                                        <span class="pull-right"></span>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="tags-resource-ID" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div class="well">


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Using+Math+and+Computational+Thinking" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Using Math and Computational Thinking</small>
                                                        </a>


                                                        <a href="http://educare.inreact-um-esi.us-east-2.elasticbeanstalk.com/video-center/?search=true&amp;tags=Physical+Science" class="btn btn-primary participant" style="margin-bottom: 5px;margin-right: 5px;">
                                                            <small>Physical Science</small>
                                                        </a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Module Readings -->

                    <!-- Module Links -->
                    <div class="panel panel-primary panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-4"
                               href="#resources-modules-links" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-link"></i> Links
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-modules-links" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Resources here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Module Links -->

                    <!-- Module Videos -->
                    <div class="panel panel-success panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-4"
                               href="#resources-modules-videos" class="text-white">
                                <h4 class="panel-title">
                                    <i class="ti-video-camera"></i> Videos
                                    <span class="pull-right"></span>
                                </h4>
                            </a>
                        </div>
                        <div id="resources-modules-videos" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                                    <strong> Head's up!</strong> There are no Resources here yet. Check back again soon.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Module Videos -->
                </div>
            </div>
            <!-- Modules -->
        </div>
        <!--tab ends-->
    </div>

</section>

@endsection
