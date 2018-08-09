<!-- resources/views/auth/reset.blade.php -->

<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <div class="error full">{{ $error }}</div>
            @endforeach
        </ul>
        <br>
    @endif
    <div class="errors">

    </div>
    @if($set == 0)

    <div>
        <label for="email">Email Address</label>
        <input type="email" data-email title="Email" class="required" name="email" value="{{ old('email') }}">
    </div>

    @else

        <input type="hidden" name="email" value="{{$email}}">

    @endif

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" class="required" title="Password" data-trim data-min-chars="6">
    </div>

    <div>
        <label for="password">Confirm Password</label>
        <input type="password" name="password_confirmation" class="required" title="Password confirmation" data-trim data-min-chars="6">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">
            {{$set == 0 ? "Reset Password" : "Set Password"}}
        </button>
    </div>
</form>
