<form method="POST" action="{{ route('messages.store') }}" class="form-new-message" data-toggle="validator">
    {!! csrf_field() !!}

    <div class="errors">

    </div>

    <input type="hidden" id="message-content" name="content" value="">

    <div class="form-group tag-box">
        <label for="participants[]" class="control-label">To: <span class="text-danger">*</span></label>
        <select id="participants[]" name="participants[]" title="Participants" class="required form-control select2 participants" multiple="multiple" style="width:100%" required></select>
    </div>

    <label for="title" class="control-label">Title <span class="text-danger">*</span></label>
    <input name="title" placeholder="Title"  class="required form-control" title="Title" value="" required />

    <label for="description" class="control-label">Message <span class="text-danger">*</span></label>
    <textarea name="description" id="description" placeholder="Brief Description" title="Description" class="form-control resize_vertical editable" required></textarea>

    {{--@if(isSet($crosscuttingConcepts) && isSet($practices) && isSet($coreIdeas))--}}
    {{--<div class="well">--}}
        {{--<strong><small><i class="ti-tag"></i> TAGS</small></strong>--}}
        {{--<hr />--}}
        {{--<div class="form-group tag-box" style="overflow: auto;">--}}
            {{--<div class="col-md-4">--}}
                {{--<label for="crosscutting" class="control-label">Crosscutting Concepts</label>--}}
                {{--<select name="tags[]" id="crosscutting" multiple="multiple" class="form-control select-box-multiple">--}}
                    {{--@foreach($crosscuttingConcepts as $crosscuttingConcept)--}}
                        {{--<option value="{{$crosscuttingConcept->id}}">{{$crosscuttingConcept->tag}}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<label for="practices" class="control-label">Practices</label>--}}
                {{--<select name="tags[]" id="practices" multiple="multiple" class="form-control select-box-multiple">--}}
                    {{--@foreach($practices as $practice)--}}
                        {{--<option value="{{$practice->id}}">{{$practice->tag}}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<label for="practices" class="control-label">Core Ideas</label>--}}
                {{--<select name="tags[]" id="coreideas" multiple="multiple" class="form-control select-box-multiple">--}}
                    {{--@foreach($coreIdeas as $coreIdea)--}}
                        {{--<option value="{{$coreIdea->id}}">{{$coreIdea->tag}}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}

    {{--<div class="editable-wrap">--}}
        {{--<div class="editable" data-placeholder="Content"></div>--}}
    {{--</div>--}}

    {{--<button name="action" value="post" class="btn btn-success">Send</button>
    <button class="btn btn-cancel">Cancel</button>--}}
    <div class="modal-footer">
        <button type="submit" class="btn btn-success new_message">
            <span class="glyphicon glyphicon-ok-sign"></span> Send Message
        </button>
        <button type="button" class="btn btn-danger btn-cancel" data-dismiss="modal">
            <span class="glyphicon glyphicon-remove"></span> Cancel
        </button>
    </div>
</form>
