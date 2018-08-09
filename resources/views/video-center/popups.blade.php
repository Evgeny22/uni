@if($page == 'video')
<span style="display:none;" id="video_id">{{$video->id}}</span>
<article aria-hidden="true" class="modal fade animated edit-post" id="edit-video" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Edit Video Post</h4>
            </div>
            <form method="POST" action="{{ route('video-center.update', ['id' => $video->id]) }}"  data-toggle="validator">
            <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="errors">

                    </div>

                    <div class="step-1">
                        <input type="hidden" id="message-content" name="content" value="{{ $video->content }}">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input name="title" placeholder="Title" title="Title" class="required form-control" required value="{{ $video->title }}">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" required title="Description" class="form-control resize_vertical required">{{ $video->description }}</textarea>
                        {{--<div class="well">--}}
                            {{--<strong><small><i class="ti-tag"></i> Tags <span class="text-danger">*</span></small></strong>--}}
                            {{--<hr />--}}
                            {{-- <div class="form-group tag-box">--}}
                                 {{----}}{{----}}{{--<label for="participants[]" class="control-label">--}}
                                     {{--<strong><small>Share With <span class="text-danger">*</span></small></strong>--}}
                                 {{--</label>--}}{{----}}{{----}}
                                 {{--<select id="participants[]" name="participants[]" class="form-control select2 participants required" multiple="multiple" style="width:100%">--}}
                                     {{--@foreach($video->participants as $participant)--}}
                                         {{--<option value="{{ $participant->id }}" selected="selected">{{ $participant->name }}</option>--}}
                                     {{--@endforeach--}}
                                 {{--</select>--}}
                             {{--</div>--}}
                            {{--<div class="form-group tag-box" style="overflow: auto;">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label for="crosscutting" class="control-label">Crosscutting Concepts</label>--}}
                                    {{--<select required name="tags[]" id="crosscutting" multiple="multiple" class="form-control select-box-multiple">--}}
                                        {{--@foreach($crosscuttingConcepts as $crosscuttingConcept)--}}
                                            {{--<option value="{{$crosscuttingConcept->id}}" @if(in_array($crosscuttingConcept->tag, $videoTags)) selected="selected" @endif>{{$crosscuttingConcept->tag}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                {{--<div class="col-md-4">--}}
                                    {{--<label for="practices" class="control-label">Practices</label>--}}
                                    {{--<select required name="tags[]" id="practices" multiple="multiple" class="form-control select-box-multiple">--}}
                                        {{--@foreach($practices as $practice)--}}
                                            {{--<option value="{{$practice->id}}" @if(in_array($practice->tag, $videoTags))selected="selected" @endif>{{$practice->tag}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                {{--<div class="col-md-4">--}}
                                    {{--<label for="practices" class="control-label">Core Ideas</label>--}}
                                    {{--<select required name="tags[]" id="coreideas" multiple="multiple" class="form-control select-box-multiple">--}}
                                        {{--@foreach($coreIdeas as $coreIdea)--}}
                                            {{--<option value="{{$coreIdea->id}}" @if(in_array($coreIdea->tag, $videoTags))selected="selected" @endif>{{$coreIdea->tag}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>


            </div>
            <div class="modal-footer">
                <button name="action" type="submit" value="post" class="btn btn-success edit-video-post" role="submit">Save Changes</button>
                <button name="action" value="cancel" class="btn btn-danger btn-cancel" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</article>
<article class="modal fade animated remove-post" id="remove-video" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Delete Video</h4>
            </div>
            <form method="post" action="{{ route('video-center.destroy', ['id' => $video->id]) }}">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this video?
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="action" type="submit" value="post" class="btn btn-success" role="submit">Yes</button>
                    <button name="action" value="cancel" class="btn btn-danger btn-cancel" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</article>
<article class="modal fade animated exemplar-request" id="exemplar-request" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Video Post Resource Submission</h4>
            </div>
            <form method="post" action="/video-center/{{ $video->id }}/exemplar">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <p>Are you sure you would like this video post to become a resource? Once approved, it will become public on this website.</p>
                    {!! csrf_field() !!}

                    {{--<label for="title">Title <span class="text-danger">*</span></label>--}}
                    {{--<input name="title" title="Title" class="required form-control" value="{{ $video->title }}">--}}

                    {{--<label for="reason">Reason <span class="text-danger">*</span></label>--}}
                    {{--<textarea name="reason" placeholder="Please explain reason for the request" class="required no-editor form-control"></textarea>--}}
                </div>
                <div class="modal-footer">
                    <button name="action" type="submit" value="post" class="btn btn-success" role="submit">Make Resource</button>
                    <button name="action" value="cancel" class="btn btn-danger btn-cancel" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</article>
<article class="modal fade animated exemplar-remove" id="exemplar-remove" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Remove Resource Status</h4>
            </div>
            <form method="post" action="/video-center/{{ $video->id }}/exemplar">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <p>Are you sure you would like to remove the "Resource" status from this video post?</p>
                    {!! csrf_field() !!}

                    <input type="hidden" name="_method" value="DELETE">
                    {{--<label for="reason">Reason <span class="text-danger">*</span></label>--}}
                    {{--<textarea name="reason" placeholder="Please explain reason for removing this video's status" class="required no-editor form-control"></textarea>--}}
                </div>
                <div class="modal-footer">
                    <button name="action" type="submit" value="post" class="btn btn-success" role="submit">Remove Status</button>
                    <button name="action" value="cancel" class="btn btn-danger btn-cancel" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</article>
@endif
<div id="popup">

    <article class="module new-video">

        <h2 class="vc-bg">New Video <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content" id="submit-video">

            <form method="post" action="{{ route('video-center.store') }}">

                {!! csrf_field() !!}

                <div class="errors" id="video-errors">

                </div>
                <button type="button" class="btn btn-danger btn-cancel cancel-upload topbtn" data-dismiss="modal" style="display:none; margin-bottom: 10px;">
                    <span class="glyphicon glyphicon-remove"></span> Cancel Upload & Start Over
                </button>
                <div class="video-limits" style="clear: both;">

                    <div class="alert alert-info">
                        <strong>Heads up!</strong> The max file upload size is 1GB.<br />The only accepted file types are: MP3, MP4, AVI, WMV & MOV.
                    </div>
                    {{--<button type="button" class="btn btn-success vc-bg" id="select-video" style="margin-bottom: 12px;">Choose Video</button>--}}
                            <!--<div id="wistia-upload-widget" alt="Choose Video"></div>-->
                    <div class="wistia-upload-container">
                        <div id="selected-video">No video has been selected.</div>

                        <div id="wistia-upload-widget" alt="Choose Video" title="Choose Video">
                            <div class="wistia_upload_button wistia_upload_video" style="position: relative;"><div class="wistia_upload_button_text">Choose Video</div>
                            </div>
                            <input id="wuw" type="file" accept="video/*,video/mp4,video/x-m4v" style="visibility: hidden; position: absolute; width: 1px; height: 1px;">
                        </div>
                    </div>
                    <div class="wistia-progress progress" style="display:none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="step-1">

                    <label for="title" id="titleLabel">Title <span class="text-danger">*</span></label>
                    <input name="title" title="Title" class="required form-control" required>

                    <label for="description" id="descriptionLabel">Description <span class="text-danger">*</span></label>
                    <textarea name="description" title="Description" required class="form-control resize_vertical required" style="height:250px;"></textarea>

                    {{--<div class="well">--}}
                    {{--<div class="form-group tag-box">--}}
                    {{--<select id="participants[]" name="participants[]" title="Participants" class="form-control select2 participants required" multiple="multiple" style="width:100%"></select>--}}
                    {{--</div>--}}

                        {{--</div>--}}
                    {{--<div class="well">--}}
                        {{--<strong><small><i class="ti-tag"></i> Tags <span class="text-danger">*</span></small></strong>--}}
                        {{--<hr />--}}
                        {{--<div class="form-group tag-box">--}}
                            {{--<select id="participants[]" name="participants[]" title="Participants" class="form-control select2 participants required" multiple="multiple" style="width:100%"></select>--}}
                        {{--</div>--}}
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

                </div>

                <div id="output"></div>

                {{--<button class="btn btn-primary vc-bg" id="go-back">Go Back</button>--}}
                {{-- <button type="submit" class="btn btn-primary btn-submit" id="submitVideoPost">Upload Video</button>
                 <button type="button" class="btn btn-danger btn-cancel">Cancel</button>--}}

                {{--<button type="submit" class="btn btn-success pull-left" id="submitVideoPost">
                    <i class="fa ti-plus icon-align"></i> Upload Video
                </button>--}}





                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitVideoPost">
                        <span class="glyphicon glyphicon-ok-sign"></span> Upload Video
                    </button>
                    <button type="button" class="btn btn-danger btn-cancel cancel-upload" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>

                {{--<button type="button" class="btn btn-danger btn-cancel pull-right" id="close_step_update" data-dismiss="modal">
                    Cancel
                    <i class="fa ti-close icon-align"></i>
                </button>--}}
            </form>
        </div>
    </article>

    @if($page == 'video')

    <span style="display:none;" id="video_id">{{$video->id}}</span>

    <article class="module exemplar-request">
        <h2 class="vc-bg">Video Post Resource Submission</h2>

        <div class="module-content">
            <p>Are you sure you would like this video post to become a resource? Once approved, it will become public on this website.</p>
            <form method="post" action="/video-center/{{ $video->id }}/exemplar">
                {!! csrf_field() !!}

                <label for="title">Title <span class="text-danger">*</span></label>
                <input name="title" title="Title" class="required form-control" value="{{ $video->title }}">

                <label for="reason">Description <span class="text-danger">*</span></label>
                <textarea name="reason" placeholder="Please explain reason for the request" class="required no-editor form-control">{{ $video->description }}</textarea>

                <button name="action" value="post" class="btn btn-vc" role="submit">Submit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>
            </form>
        </div>
    </article>

    <article class="module exemplar-make">

        <h2 class="vc-bg">Approve Video Post Exemplar Status</h2>

        <div class="module-content">

            <p>Are you sure you would like to approve this post as an exemplar?</p>

            <form method="post" action="/video-center/{{ $video->id }}/exemplar">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <button name="action" value="post" class="btn btn-vc" role="submit">Make Exemplar</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>
            </form>

        </div>

    </article>

    <article class="module exemplar-response">

        <h2 class="vc-bg">Approve/Deny Video Post Exemplar Status</h2>

        <div class="module-content">

            <p>A request has been made for this post to become an exemplar. Below is the Master Teacher reasoning for this request</p>

            @if (isset($video->exemplar()->reason))<p class="reasoning">"{{ $video->exemplar()->reason }}"</p>@endif

            <form method="post" action="/video-center/{{$video->id}}/exemplar">

                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="">
                <textarea name="reason" placeholder="Please explain your reason"></textarea>
                <button name="action" value="post" class="btn btn-vc" role="submit" data-target="PUT">Make Exemplar</button>
                <button name="action" value="post" class="btn btn-vc" role="submit" data-target="DELETE">Deny Exemplar</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    <article class="module exemplar-remove">

        <h2 class="vc-bg">Remove Exemplar Status</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove the exemplar status from this video post?</p>

            <form method="post" action="/video-center/{{ $video->id }}/exemplar">

                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <textarea name="reason" placeholder="Please explain reason for reject this video"></textarea>
                <button name="action" value="post" class="btn btn-vc" role="submit">Remove Exemplar</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    <!-- Pending Requests -->

        <!-- Approve Request to Make Exemplar -->
        <article class="module exemplar-response-approve">

            <h2 class="vc-bg">Approve Video Post Exemplar Status</h2>

            <div class="module-content">

                <p>A request has been made for this post to become an exemplar. Below is the Master Teacher reasoning for this request</p>

                @if (isset($video->exemplar()->reason))<p class="reasoning">"{{ $video->exemplar()->reason }}"</p>@endif

                <form method="post" action="/video-center/{{$video->id}}/exemplar">

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <textarea name="reason" placeholder="Please explain your reason"></textarea>
                    <button name="action" value="post" class="btn btn-success" type="submit">Approve</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>
                </form>

            </div>

        </article>
        <!-- / Approve Request to Make Exemplar -->

        <!-- Deny Request to Make Exemplar -->
        <article class="module exemplar-response-deny">

            <h2 class="vc-bg">Approve/Deny Video Post Exemplar Status</h2>

            <div class="module-content">

                <p>A request has been made for this post to become an exemplar. Below is the Master Teacher reasoning for this request</p>

                @if (isset($video->exemplar()->reason))<p class="reasoning">"{{ $video->exemplar()->reason }}"</p>@endif

                <form method="post" action="/video-center/{{$video->id}}/exemplar">

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <textarea name="reason" placeholder="Please explain your reason"></textarea>
                    <button name="action" value="post" class="btn btn-danger" type="submit">Deny</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>
        <!-- / Deny Request to Make Exemplar -->

    <!-- / Pending Requests -->

    <article class="module new-document">

        <h2 class="vc-bg">New Supporting Document</h2>

        <div class="module-content">

            <form method="post" action="/video-center/{{ $video->id }}/documents" enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <div class="change-document">
                    <input type="file" name="document" accept="application/pdf,application/msword,application/vnd.ms-excel,text/plain,image/*,video/*,audio/*" id="document" class="required btn btn-success" title="Supporting Document">
                    <label for="document" class="btn btn-success">Choose Document</label>
                </div>

                <span class="input-group">
                    <label for="title">Title of Document <span class="text-danger">*</span></label>
                    <input class="form-control required" id="sd_name" name="title" title="Title of Document" placeholder="">
                </span>

                <input type="hidden" name="description" value="">

                <div class="modal-footer">
                    <button type="submit" value="post" class="btn btn-primary" role="submit">Upload</button>
                    <button type="button" value="cancel" class="btn btn-danger" data-trigger-close="new-document">Cancel</button>
                </div>
            </form>

        </div>

    </article>

    <article class="module remove-document">

        <h2 class="vc-bg">Remove Video Document</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove the document <span class="remove-document-title vc-color"></span> from this video?</p><p>This can not be undone.</p>

            <form method="post" action="">

                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">

                <button name="action" value="post" class="btn btn-vc" role="submit">Submit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    @endif

</div>