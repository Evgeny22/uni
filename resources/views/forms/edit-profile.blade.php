<form method="POST" action="{{ route('update-profile', ['id' => $profile->id ]) }}">
    {!! csrf_field() !!}
    <div class="errors">

    </div>

    <label for="name">Full Name</label>
    <input name="name" placeholder="Full Name" value="{{ $profile->name }}" title="Full Name" class="required">

    <label for="email">Email</label>
    <input name="email" placeholder="Email" value="{{ $profile->email  }}" title="Email"  data-email class="required">

    <label for="nickname">Nickname</label>
    <input name="nickname" placeholder="Nickname" value="{{ $profile->nickname }}">

    <label for="bio">Brief Bio</label>
    <textarea name="bio" placeholder="Brief Bio" class="no-ck-editor">{{ $profile->bio }}</textarea>
    @if ($user->is('super_admin'))
    <label for="name">Coach</label>
    <div class="form-group">
        <?php
        $users = App\User::where('role_id' ,'=' ,3)->pluck('name','id')->toArray();
        ?>
        <select name="masterteacher" id="masterteacher" class="form-control">
            @foreach($users as $key => $user)
                <option value="{{ $key }}">{{ $user }}</option>
            @endforeach
        </select>
        <script>
            $('#masterteacher').val({{ $profile->masterteacher }});
        </script>
    </div>
    @else
        <label for="name">Coach</label>
        <div class="form-group">
            <?php
            $users = App\User::where('role_id' ,'=' ,3)->pluck('name','id')->toArray();
            ?>
            <select name="masterteacher" id="masterteacher" class="form-control" disabled>
                @foreach($users as $key => $user)
                    <option value="{{ $key }}">{{ $user }}</option>
                @endforeach
            </select>
            <script>
                $('#masterteacher').val({{ $profile->masterteacher }});
            </script>
        </div>
    @endif

    {{--@if ($user->is('super_admin'))--}}
        {{--<label for="role_id">Role</label>--}}
        {{--<select name="role_id" title="Role">--}}
            {{--@foreach($roles as $role)--}}
                {{--<option value="{{ $role->id }}"--}}
                        {{--@if ($profile->role_id == $role->id)--}}
                        {{--selected--}}
                        {{--@endif--}}
                {{-->{{ $role->display_name }}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
        {{--<label>Module Permissions</label>--}}
        {{--<input type="checkbox" value="checked" name="p_access_progressbars"> Progress Bars--}}
        {{--<input type="checkbox" value="checked" name="p_access_videocenter"> Video Center--}}
        {{--<input type="checkbox" value="checked" name="p_access_instructionaldesign"> Instructional Design--}}
        {{--<input type="checkbox" value="checked" name="p_access_resourcesmodules"> Resources & Modules--}}
        {{--<input type="checkbox" value="checked" name="p_access_messageboard"> Message Board--}}
    {{--@endif--}}
    <button name="action" value="save" type="submit" class="btn btn-success">Save Profile Info</button>
</form>
