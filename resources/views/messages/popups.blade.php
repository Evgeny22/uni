<div id="popup">

    <article class="module new-post">

        <h2 class="secondary-bg">New Message</h2>

        <div class="module-content">

            @include('forms.new-message')

        </div>

    </article>

    <article class="module remove-post">

        <h2 class="secondary-bg">Remove Message Post</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove the post <span class="remove-post-title secondary-color"></span>? This can not be undone and will remove all subsequent comments as well.</p>

            <form method="post" action="">
                {!! csrf_field() !!}
                <button name="action" value="post" class="btn btn-secondary" role="submit">Remove</button>
                <button name="action" value="cancel" class="btn btn-cancel">Close</button>

            </form>

        </div>

    </article>

    @if (isSet($message))

    <article class="module edit-post">

        <h2 class="secondary-bg">Edit Message</h2>

        <div class="module-content">

            {{--<form method="POST" action="">
                {!! csrf_field() !!}
                <div class="errors">

                </div>
                <input type="hidden" name="_method" value="PUT">

                <input type="hidden" id="message-content" name="content" value="">

                <input name="title" placeholder="Title" title="12" class="required" value="{{ old('title') }}" />
                <div class="editable-wrap">
                    <div class="editable" data-placeholder="Content"></div>
                </div>
                <select name="participants[]" class="participants" multiple="multiple" title="Participants">
                    <option value=""></option>
                </select>

                <button name="action" value="post" class="btn btn-secondary" role="submit">Edit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>
            </form>--}}

            <form method="POST" action="" class="form-new-message">
                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="hidden" id="message-content" name="content" value="">

                <div class="form-group tag-box">
                    <label for="participants[]" class="control-label">To: <span class="text-danger">*</span></label>
                    <select id="participants[]" name="participants[]" title="Participants" class="required form-control select2 participants" multiple="multiple" style="width:100%">
                        @foreach($message->participants as $participant)
                            <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="title" class="control-label">Title <span class="text-danger">*</span></label>
                <input name="title" placeholder="Title"  class="required form-control" title="Title" value="{{ isSet($message) ? $message->title : '' }}" />

                <label for="description" class="control-label">Message <span class="text-danger">*</span></label>
                <textarea name="description" placeholder="Brief Description" title="Description" class="required form-control resize_vertical editable no-editor">{{ isSet($message) ? $message->content : '' }}</textarea>

                @if(isSet($crosscuttingConcepts) && isSet($practices) && isSet($coreIdeas))
                    <div class="well">
                        <strong><small><i class="ti-tag"></i> TAGS</small></strong>
                        <hr />
                        <div class="form-group tag-box" style="overflow: auto;">
                            <div class="col-md-4">
                                <label for="crosscutting" class="control-label">Crosscutting Concepts</label>
                                <select name="tags[]" id="crosscutting" multiple="multiple" class="form-control select-box-multiple">
                                    @foreach($crosscuttingConcepts as $crosscuttingConcept)
                                        <option value="{{$crosscuttingConcept->id}}">{{$crosscuttingConcept->tag}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="practices" class="control-label">Practices</label>
                                <select name="tags[]" id="practices" multiple="multiple" class="form-control select-box-multiple">
                                    @foreach($practices as $practice)
                                        <option value="{{$practice->id}}">{{$practice->tag}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="practices" class="control-label">Core Ideas</label>
                                <select name="tags[]" id="coreideas" multiple="multiple" class="form-control select-box-multiple">
                                    @foreach($coreIdeas as $coreIdea)
                                        <option value="{{$coreIdea->id}}">{{$coreIdea->tag}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                {{--<div class="editable-wrap">--}}
                {{--<div class="editable" data-placeholder="Content"></div>--}}
                {{--</div>--}}

                <button name="action" value="post" class="btn btn-success" role="submit">Edit</button>
                <button class="btn btn-cancel btn-danger">Cancel</button>
            </form>


        </div>

    </article>

    @endif

</div>