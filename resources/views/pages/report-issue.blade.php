@extends('layouts.default')

@section('content')
<section class="content">
    <!--main content-->
    <div class="row">
        <div class="col-md-6">
            <div class="panel ">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ti-headphone-alt"></i> Wells
                    </h3>
                    <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                    <i class="fa fa-fw ti-close removepanel clickable"></i>
                                </span>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="well well-sm">
                            Look, I'm in a small well!
                        </div>
                        <div class="well">
                            Look, I'm in a well!
                        </div>
                        <div class="well well-lg">
                            Look, I'm in a large well!
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel ">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ti-angle-double-right"></i> Breadcrumbs
                    </h3>
                    <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                    <i class="fa fa-fw ti-close removepanel clickable"></i>
                                </span>
                </div>
                <div class="panel-body">
                    <div class="bs-example">
                        <ul class="breadcrumb">
                            <li class="next">
                                <a href="#">Home</a>
                            </li>
                            <li class="next">
                                <a href="#">
                                    UI Features
                                </a>
                            </li>
                            <li>Pickers</li>
                        </ul>
                        <ul class="breadcrumb breadcrumb1">
                            <li class="next1">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="next1">
                                <a href="#">Charts</a>
                            </li>
                            <li>
                                Flot Charts
                            </li>
                        </ul>
                        <ul class="breadcrumb breadcrumb2" style="margin-bottom: 20px;">
                            <li class="next2">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="next2">
                                <a href="#">Tables</a>
                            </li>
                            <li>
                                Data Tables
                            </li>
                        </ul>
                        <ul class="breadcrumb breadcrumb3" style="margin-bottom: 15px;">
                            <li class="next">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="next1">
                                <a href="#">Forms</a>
                            </li>
                            <li>
                                Form Elements
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Panel Primary
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Panel Success
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Panel Warning
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Panel Danger
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Panel Info</h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Panel Default
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
    </div>
    <!--main content ends-->
</section>
@endsection