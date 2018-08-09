<form action="{{ route('login') }}" id="authentication" method="post" class="login_validator">
    {!! csrf_field() !!}

    <div class="form-group errors">
        @if (count($errors) > 0)
            <ul>
                @foreach ($errors->all() as $error)
                    <div class="error full">{{ $error }}</div>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="form-group">
        <label for="email" class="sr-only"> E-mail</label>
        <input type="text" class="form-control  form-control-lg required" id="email" name="email" placeholder="E-mail" data-email value="{{ old('email') }}">
    </div>
    <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input type="password" class="form-control form-control-lg required" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group checkbox">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">&nbsp; Remember Me
        </label>
    </div>
    <div class="form-group">
        <input type="submit" value="Sign In" class="btn btn-primary btn-block"/>
    </div>
    <a href="{{ route('forgot') }}" id="forgot" class="forgot"> Forgot Password ? </a>

    <span class="pull-right sign-up">New ? <a href="{{ route('signup') }}">Sign Up</a></span>
</form>
