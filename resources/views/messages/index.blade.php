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
        'hideTags' => true
    ])

    <div class="row">
        <!--tab starts-->
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#messages-all" data-toggle="tab"><i class="ti-comment-alt"></i> My Messages</a>
            </li>
            <li>
                <a href="#messages-saved" data-toggle="tab"><i class="ti-gift"></i> Saved Messages</a>
            </li>
            <li>
                <a href="#messages-deleted" data-toggle="tab"><i class="ti-trash"></i> Deleted Messages</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content resources-container">
            <div class="tab-pane active in fade" id="messages-all">
                @if(count($messages))
                    @include('message_list')
                    {!! $messages->render() !!}
                @else
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> You haven't received any messages yet.
                    </div>
                @endif
            </div>
            <div class="tab-pane" id="messages-saved">
                @if(count($savedMessagesIds))
                    @foreach ($messages as $message)
                        @if(in_array($message->id, $savedMessagesIds))
                            @if($message->author)
                                @include('partials.message', $message)
                            @endif
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> You haven't saved any messages yet.
                    </div>
                @endif
            </div>
            <div class="tab-pane" id="messages-deleted">
                @if(count($deletedMessagesIds))
                    @foreach ($messages as $message)
                        @if(in_array($message->id, $deletedMessagesIds))
                            @if($message->author)
                                @include('partials.message', $message)
                            @endif
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-info" style="width: 100%;display: inline-block;margin-bottom: 1px;">
                        <strong> Head's up!</strong> You don't have any deleted messages.
                    </div>
                @endif
            </div>
        </div>
    </div>

</section>
@if (request('search') != '1')
    <script>
        $(".search-form").hide();
    </script>
@endif
@endsection
