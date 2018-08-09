<div id="popup">

    <article class="module new-post new-resource">

        <h2 class="resources-bg">New Resource</h2>

        <div class="module-content">

            <form method="post" action="{{route('resource.store')}}" enctype="multipart/form-data" data-toggle="validator">
                <input type="hidden" name="is_private" value="1" />
                <small>*Resources are private by default.</small>
                {!! csrf_field() !!}
                <div class="errors">

                </div>

                <label for="title" id="titleLabel">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" placeholder="Title" class="required form-control required" title="Title" required>

                <label for="resource_type_id" id="descriptionLabel">Category <span class="text-danger">*</span></label>
                <select name="resource_type_id" class="required form-control" title="Category" required>
                    <option value="0">-- Select --</option>
                    @foreach($resource_types as $resource_type)
                        <option value="{{$resource_type->id}}">{{$resource_type->type}}</option>
                    @endforeach
                </select>

                <div class="change-document" style="display: none; margin-top: 10px;">
                    <input type="file" name="document" accept=".pdf,.csv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" id="document" class="required" title="Document" />
                    <label for="document" class="btn btn-primary">Choose Document</label>
                    <p>*PDF, DOC or XLSX formats only.</p>
                </div>

                <div class="link-field" style="display: none; margin-top: 20px;">
                    <label for="remote_url" id="remoreUrlLabel">Link <span class="text-danger">*</span></label>
                    <input type="text" name="remote_url" placeholder="Link" class="required form-control" data-required-if-not="document" title="Remote url or resource document" id="remote_url">
                </div>

                <label for="description" id="descriptionLabel">Description <span class="text-danger">*</span></label>
                <textarea name="description" placeholder="Brief Description" title="Description" class="form-control resize_vertical is-popup" required></textarea>

                {{--<div class="well">--}}
                    {{--<strong><small><i class="ti-tag"></i> Tags  <span class="text-danger">*</span></small></strong>--}}
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success resource-upload">
                        <span class="glyphicon glyphicon-ok-sign"></span> Upload Resource
                    </button>
                    <button type="button" class="btn btn-danger btn-cancel" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </article>

    @if (isSet($resource))

    <article class="module edit-post">

        <h2 class="resources-bg">Edit Resource</h2>

        <div class="module-content">

            <form method="post" action="{{ route('resources.update', ['id' => $resource->id]) }}"  enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="hidden" name="document_hidden" id="document_hidden">


                <div class="errors">

                </div>

                <!--<div class="change-document">
                    <input type="file" name="document" class="btn btn-action" accept=".pdf,.csv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                    <label for="document" class="btn btn-primary">Change Document</label>
                    <p name="current_document"></p>
                    <p>PDF, DOC or XLSX formats only.</p>
                </div>-->

                <label for="title" id="titleLabel">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" placeholder="Title" class="required form-control" title="Title" value="{{ $resource->title }}">

                <label for="remote_url" id="remoreUrlLabel">Link</label>
                <input type="text" name="remote_url" placeholder="Link" class="form-control" data-required-if-not="document" title="Remote url or resource document" id="remote_url" value="{{ $resource->remote_url }}">

                <label for="resource_type_id" id="descriptionLabel">Category <span class="text-danger">*</span></label>
                <select name="resource_type_id" class="required form-control required" title="Category">
                    <option value="">-- Select --</option>
                    @foreach($resource_types as $resource_type)
                        <option value="{{$resource_type->id}}"
                            @if ($resource->resource_type_id == $resource_type->id)
                                selected="selected"
                            @endif
                        >{{$resource_type->type}}</option>
                    @endforeach
                </select>

                <label for="description" id="descriptionLabel">Description <span class="text-danger">*</span></label>
                <textarea name="description" placeholder="Brief Description" class="form-control resize_vertical is-popup" title="Description">{{ $resource->description }}</textarea>

                <div class="well">
                    <strong><small><i class="ti-tag"></i> Tags</small></strong>
                    <hr />
                    {{--<div class="form-group tag-box">
                        <select id="participants[]" name="participants[]" title="Participants" class="form-control select2 participants required" multiple="multiple" style="width:100%"></select>
                    </div>--}}
                    <div class="form-group tag-box" style="overflow: auto;">
                        <div class="col-md-4">
                            <label for="crosscutting" class="control-label">Crosscutting Concepts</label>
                            <select name="tags[]" id="crosscutting" multiple="multiple" class="form-control select-box-multiple">
                                @foreach($crosscuttingConcepts as $crosscuttingConcept)
                                    <option value="{{$crosscuttingConcept->id}}" @if(in_array($crosscuttingConcept->tag, $resourceTags)) selected="selected" @endif>{{$crosscuttingConcept->tag}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="practices" class="control-label">Practices</label>
                            <select name="tags[]" id="practices" multiple="multiple" class="form-control select-box-multiple">
                                @foreach($practices as $practice)
                                    <option value="{{$practice->id}}" @if(in_array($practice->tag, $resourceTags))selected="selected" @endif>{{$practice->tag}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="practices" class="control-label">Core Ideas</label>
                            <select name="tags[]" id="coreideas" multiple="multiple" class="form-control select-box-multiple">
                                @foreach($coreIdeas as $coreIdea)
                                    <option value="{{$coreIdea->id}}" @if(in_array($coreIdea->tag, $resourceTags))selected="selected" @endif>{{$coreIdea->tag}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{--<div class="full">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="resource_category" title="Category">
                        <option value="none">No Category</option>
                        <option value="new">Create New Category...</option>
                        @foreach($resourceCategories as $resourceCategory)
                            <option value="{{$resourceCategory->id}}">{{$resourceCategory->name}}</option>
                        @endforeach
                    </select>

                    <input class="new_category_name form-control" name="new_category_name" value="" placeholder="New category name..." style="display: none;" />
                </div>--}}

                {{--<button class="btn resources-bg" role="submit">Post</button>
                <button class="btn btn-cancel">Cancel</button>--}}

                {{--<button name="action" value="post" class="btn resources-bg" role="submit">Edit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>--}}

                <button type="button" class="btn btn-danger pull-right btn-cancel" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
                <button type="submit" class="btn btn-success pull-right">
                    <span class="glyphicon glyphicon-ok-sign"></span> Save Document
                </button>
            </form>
        </div>
    </article>

    <article class="module remove-post">
        <h2 style="color: #000;">Delete Resource</h2>
        <div class="module-content">
            <div class="alert alert-warning">
                <span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this resource?
            </div>
            <form method="post" action="{{ route('resources.delete', ['id' => $resource->id]) }}">
                {!! csrf_field() !!}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-ok-sign"></span> Yes
                    </button>
                    <button type="button" class="btn btn-danger btn-cancel" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> No
                    </button>

                </div>
            </form>
        </div>
    </article>

        {{--<article class="module exemplar-request">
            <h2 class="vc-bg">Video Post Resource Submission</h2>

            <div class="module-content">
                <p>Are you sure you would like this video post to become a resource? Once approved, it will become public on this website.</p>
                <form method="post" action="/resources/{{ $resource->id }}/exemplar">
                    {!! csrf_field() !!}

                    <label for="title">Title <span class="text-danger">*</span></label>
                    <input name="title" title="Title" class="required form-control" value="{{ $video->title }}">

                    <label for="reason">Description <span class="text-danger">*</span></label>
                    <textarea name="reason" placeholder="Please explain reason for the request" class="required form-control">{{ $video->description }}</textarea>

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

        </article>--}}

    @endif


</div>