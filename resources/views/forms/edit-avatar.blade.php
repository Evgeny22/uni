<form method="POST" action="{{ route('update-avatar', ['id' => $profile->id ]) }}" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <div class="profile-pic"><img src="{{ $profile->avatar->url() }}" alt="{{ $profile->display_name }}"></div>

    <div class="change-avatar">

        <!--<input type="file" name="avatar" class="btn btn-action" />-->

        <input type="file" name="avatar" accept="image/*" id="avatar" />

        <label for="avatar" class="btn btn-warning btn-sm" id="avatar-browse">Choose a New Avatar Photo</label>

        <br /><button type="submit" id="change-avatar" class="btn btn btn-success" style="display: none; margin-top: 10px;">Change Avatar</button>

        <p>*Image must be at least 300px wide. JPEG or PNG formats only.</p>

    </div>

</form>

<script>
    $("input#avatar").change(function () {
        $("#change-avatar").show();
    });
</script>