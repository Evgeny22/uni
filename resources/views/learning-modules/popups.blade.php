<div id="popup">

    @if ($user->is('super_admin'))

    <article class="module new-post">

        <h2 class="lm-bg">New Learning Module <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content" action="{{ route('learning-modules.store') }}">

            <form method="post" action="{{ route('learning-modules.store') }}" class="form-new-learning">

                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="hidden" id="learning-content" name="description" value="">
                <input name="title" class="required" title="Title" placeholder="Title">
                <input name="zoom_url" placeholder="Link">
                <div class="editable-wrap">
                    <div class="editable" data-placeholder="Brief Description"></div>
                </div>

                <button class="btn lm-bg" role="submit">Post</button>
                <button class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

        <article class="module remove-post">

            <h2 class="lm-bg">Remove Learning Module Post</h2>

            <div class="module-content">

                <p>Are you sure you would like to remove the post <span class="remove-post-title lm-color"></span>? This can not be undone and will remove all subsequent documents as well.</p>

                <form method="post" action="">
                    {!! csrf_field() !!}
                    <button name="action" value="post" class="btn lm-bg" role="submit">Remove</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Close</button>

                </form>

            </div>

        </article>

    <article class="module edit-post">

        <h2 class="lm-bg">Edit Learning Module Post</h2>

        <div class="module-content">

            <form method="POST" action="">
                {!! csrf_field() !!}

                <div class="errors">

                </div>

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="learning-content" name="description" value="">


                <input name="title" placeholder="Title" class="required" title="Title">
                <input name="zoom_url" placeholder="Zoom Link">

                <div class="editable-wrap">
                    <div class="editable" data-placeholder="File Description"></div>
                </div>

                <button name="action" value="post" class="btn lm-bg" role="submit">Edit</button>
                <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>
            </form>

        </div>

    </article>


    @if ($page == 'learning-module')

        <article class="module new-document">

            <h2 class="lm-bg">Learning Module Document Upload</h2>

            <div class="module-content">

                <form method="post" action="/learning-modules/{{ $learningModule->id }}/documents" enctype="multipart/form-data">

                    {!! csrf_field() !!}
                    <div class="errors">

                    </div>

                    <div class="change-document">

                        <input type="file" name="document" accept="image/*,.pdf,.csv,image/gif,image/jpeg,image/jpg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet," id="document" class="required" title="Supporting Document">
                        <label for="document" class="btn btn-action">Upload A Supporting Document</label>

                    </div>


                    <input name="title" placeholder="File Description">
                    <input type="hidden" name="description" value="">

                    <button name="action" value="post" class="btn btn-lm" role="submit">Submit</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

        <article class="module remove-document">

            <h2 class="lm-bg">Remove Video Document</h2>

            <div class="module-content">

                <p>Are you sure you would like to remove the document <span class="remove-document-title lm-color semi-bold"></span> from this video?</p><p>This can not be undone.</p>

                <form method="post" action="">

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">

                    <button name="action" value="post" class="btn btn-lm" role="submit">Submit</button>
                    <button name="action" value="cancel" class="btn btn-cancel">Cancel</button>

                </form>

            </div>

        </article>

    @endif

     <article class="module video-update">

        <h2 class="lm-bg">Update Learning Module Video</h2>

        <div class="module-content" id="submit-video">

            <form method="POST" action="">
                {!! csrf_field() !!}

                <input type="hidden" name="_method" value="PUT">

                <div id="wistia-upload-widget" style="width: 100%; height: 300px; float: left;"></div>

                <div id="output"></div>

                <button class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    @endif

</div>