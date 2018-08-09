@extends('layouts.default')

@section('content')

@include('resources.popups')

<section class="resources component">

    @include('resources.top')

    <div class="row">

        <article class="module full">

            <h2><i class="icon icon-{{ str_replace(" ", "-", $category) }}"></i> Resources For {{$category}} ({{$type}})</h2>

            <div class="module-content pad-wide">
                @if(count($resources)>0)
                        @include('resources_list')
                @else
                    <h3> There aren't any resources for {{$category}} ({{$type}}).</h3>
                @endif
            </div>


        </article>

        {!! $resources->render() !!}

    </div>

</section>
<a href="{{ route('resource.index') }}" class="view-all resources-color">View All Resources</a>
@endsection
