@extends('layouts.default')

@section('content')

@include('messages.popups')

<section class="message-board component message-list">

    @include('messages.top')

    {{--<div class="row">--}}

        {{--<article class="module">--}}

            {{--<h2 class="secondary-bg">Messages</h2>--}}

            {{--<div class="module-content pad-wide">--}}

                {{--@include('message_list')--}}

            {{--</div>--}}

        {{--</article>--}}

        {{--{!! $messages->render() !!}--}}

    {{--</div>--}}

    @include('partials/search_form', [
        'searchAction' => route('messages.search'),
        'cancelAction' => route('messages.index'),
        'hideTags' => false
    ])

    <div class="row">
        <!--tab starts-->
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs">
            @if(request('search') == '1')
                <li class="active">
                    <a href="#messages-all" data-toggle="tab"><i class="ti-comment-alt"></i> Search Results</a>
                </li>
            @else
            <li class="active">
                <a href="#messages-all" data-toggle="tab"><i class="ti-comment-alt"></i> My Messages</a>
            </li>
            <li>
                <a href="#messages-saved" data-toggle="tab"><i class="ti-gift"></i> Saved Messages</a>
            </li>
            <li>
                <a href="#messages-deleted" data-toggle="tab"><i class="ti-trash"></i> Deleted Messages</a>
            </li>
            @endif
        </ul>
        <!-- Tab panes -->
        <div class="tab-content resources-container">
            <div class="tab-pane active in fade" id="messages-all">
                @foreach ($messages as $message)
                    @if($message->author)
                        @include('partials.message', $message)
                    @endif
                @endforeach
            </div>
            @if (!request('search'))
            <div class="tab-pane" id="messages-saved">
                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                    <strong> Head's up!</strong> You haven't saved any messages yet.
                </div>
            </div>
            <div class="tab-pane" id="messages-deleted">
                <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                    <strong> Head's up!</strong> You don't have any deleted messages.
                </div>
            </div>
            @endif
        </div>
    </div>

</section>

@endsection
