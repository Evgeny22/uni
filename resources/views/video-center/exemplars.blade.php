@extends('layouts.default')

@section('content')

    {{--<article class="full" id="activity">--}}

        {{--<h3><i class="icon icon-list"></i> Videos Pending for Exemplar Approval</h3>--}}

        {{--<div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">--}}
            {{--<strong> Head's up!</strong> There are no Exemplars here for Approval yet. Check back again soon.--}}
        {{--</div>--}}

        {{--<ul>--}}
            {{--@foreach ($exemplars as $exemplar)--}}
                {{--{!! $exemplar->render() !!}--}}
            {{--@endforeach--}}
        {{--</ul>--}}

    {{--</article>--}}
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>Heads up!</strong> There are no Exemplars here for Approval yet. Check back again soon.
                </div>
                <button type="button" onclick="goBack()" class="btn btn-primary">Back to All My Videos</button>
            </div>
        </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    {!! $exemplars->render() !!}


@endsection


