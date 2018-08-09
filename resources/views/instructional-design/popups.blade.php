<div id="popup">

    <article class="module new-post">

        <h2 class="id-bg">New Lesson Plan <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content">

            <form method="post" action="{{ route('instructional-design.store') }}">

                {!! csrf_field() !!}

                <div class="errors">

                </div>

                @include('partials.new_lesson_plan')

            </form>

        </div>

    </article>

    <article class="module edit-post">

        <h2 class="id-bg">Edit Lesson Plan <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content">

            <form method="post" action="/instructional-design/">

                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="hidden" name="_method" value="PUT">

                <div class="error full">Please fill out all fields below.</div>

                @include('partials.new_lesson_plan')

            </form>

        </div>

    </article>

    <article class="module remove-post">

        <h2 class="id-bg">Remove Lesson Plan Post</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove the post <span class="remove-post-title id-color"></span>? This can not be undone and will remove all subsequent comments as well.</p>

            <form method="post" action="">
                {!! csrf_field() !!}

                <button name="action" value="post" class="btn id-bg" role="submit">Remove</button>
                <button name="action" value="cancel" class="btn btn-cancel">Close</button>

            </form>

        </div>

    </article>

    @if ($page == 'instructional-design-show')

        <article class="module exemplar-request">

            <h2 class="id-bg">Instructional Design Exemplar Request</h2>

            <div class="module-content">

                <p>Are you sure you would like to request for this Instructional Design post to become an exemplar?</p>

                <form method="post" action="/instructional-design/{{ $lessonPlan->id }}/exemplar">
                    {!! csrf_field() !!}

                    <textarea name="reason" placeholder="Please explain reason for the request"></textarea>
                    <button name="action" value="post" class="btn id-bg" role="submit">Request Exemplar</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module exemplar-make">

            <h2 class="id-bg">Approve Instructional Design Post Exemplar Status</h2>

            <div class="module-content">

                <p>Are you sure you would like to approve this Instructional Design post as an exemplar?</p>

                <form method="post" action="/instructional-design/{{ $lessonPlan->id }}/exemplar">

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <button name="action" value="post" class="btn id-bg" role="submit">Make Exemplar</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module exemplar-response">

        <h2 class="id-bg">Approve/Deny Instructional Design Post Exemplar Status</h2>

        <div class="module-content">

            <p>A request has been made for this Instructional Design post to become an exemplar. Below is the Master Teacher reasoning for this request</p>

            @if (isset($lessonPlan->exemplar()->reason))<p class="reasoning">"{{ $lessonPlan->exemplar()->reason }}"</p>@endif

            <form method="post" action="/instructional-design/{{$lessonPlan->id}}/exemplar">

                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="">
                <textarea name="reason" placeholder="Please explain reason for reject this lesson plan"></textarea>
                <button name="action" value="post" class="btn id-bg" role="submit" data-target="PUT">Make Exemplar</button>
                <button name="action" value="post" class="btn id-bg" role="submit" data-target="DELETE">Deny Exemplar</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

        <article class="module exemplar-remove">

            <h2 class="id-bg">Remove Exemplar Status</h2>

            <div class="module-content">

                <p>Are you sure you would like to remove the exemplar status from this Instructional Design post?</p>

                <form method="post" action="/instructional-design/{{ $lessonPlan->id }}/exemplar">

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <textarea name="reason" placeholder="Please explain reason for reject this lesson plan"></textarea>
                    <button name="action" value="post" class="btn id-bg" role="submit">Remove Exemplar</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module new-document">

            <h2 class="id-bg">Instructional Design Document Upload</h2>

            <div class="module-content">

                <form method="post" action="/instructional-design/{{ $lessonPlan->id }}/documents" enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="errors">

                    </div>

                    <div class="change-document">

                        <input type="file" name="document" accept="image/*,.pdf,.csv,image/gif,image/jpeg,image/jpg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet," id="document" class="required" title="Supporting Document">
                        <label for="document" class="btn btn-action">Upload A Supporting Document</label>

                    </div>

                    <input name="title" placeholder="File Description">


                    <input type="hidden" name="description" value="">
                    <input type="hidden" name="type" value="document">

                    <button name="action" value="post" class="btn id-bg" role="submit">Submit</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module new-lesson-plan-document">

            <h2 class="id-bg">Lesson Plan Upload</h2>

            <div class="module-content">

                <form method="post" action="/instructional-design/{{ $lessonPlan->id }}/storeLessonPlan" enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="errors">

                    </div>

                    <div class="upload-lesson-plan-document">

                        <input type="file" name="lesson_plan" id="lesson_plan" title="Lesson Plan">

                        <label for="lesson_plan" class="btn btn-action">Upload Lesson Plan</label>

                    </div>

                    <input name="title" placeholder="File Description">

                    <input type="hidden" name="description" value="">
                    <input type="hidden" name="type" value="lesson_plan">

                    <button type="submit" value="submit" class="btn id-bg" role="submit">Submit</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module remove-document">

        <h2 class="id-bg">Remove Instructional Design Supporting Document</h2>

        <div class="module-content">

            <p>Are you sure you would like to remove the document <span class="remove-document-title vc-color"></span> from this video?</p><p>This can not be undone.</p>

            <form method="post" action="">

                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">

                <button name="action" value="post" class="btn btn-id" role="submit">Submit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    @endif

</div>