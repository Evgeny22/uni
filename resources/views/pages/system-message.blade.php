@extends('layouts.default')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel ">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="ti-headphone-alt"></i> System Message
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--main content ends-->
    </section>
@endsection