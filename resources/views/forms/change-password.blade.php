<form method="POST" action="{{ route('update-password', ['id' => $profile->id ]) }}">
    {!! csrf_field() !!}
    <div class="errors">

    </div>
    <label for="password">New Password</label>
    <input type="password" name="password" placeholder="New Password" title="Password" value="" data-min-chars = "6" class="required" data-trim/>
    <label for="password2">Confirm Password</label>
    <input type="password" name="password2" placeholder="Confirm Password" value="" title="Confirm Password" data-min-chars="6" data-trim class="required" />

    <button type="submit" class="btn btn-warning btn-sm">Save Password</button>
</form>
