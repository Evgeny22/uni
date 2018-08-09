<form action="{{ route('signup') }}" id="authentication" method="post" class="signup_validator">
    {!! csrf_field() !!}

    <div class="col-md-12">
        <div class="form-group">
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
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="sign-up-name" class="sr-only">Name</label>
            <input type="text" class="form-control form-control-lg required" id="sign-up-name" name="name" placeholder="Name" value="{{ old('name') }}">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="sign-up-email" class="sr-only"> E-mail</label>
            <input type="text" class="form-control form-control-lg required" placeholder="Email Address" id="sign-up-email" name="email" value="{{ old('email') }}">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" class="form-control form-control-lg required" title="Password" data-trim data-min-chars="6" placeholder="Password" id="sign-up-pw">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="confirm-password" class="sr-only">Confirm Password</label>
            <input name="password_confirmation" title="Password confirmation" class="form-control form-control-lg required" data-trim data-min-chars="6" placeholder="Confirm Password">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="school_id" class="sr-only">School</label>
            <script>
                var schools = {!! $schools !!}
            </script>

            <div class="styled-select" for="school_id">

                <select class="form-control form-control-lg" name="school_id" id="sign-up-school">
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="styled-select" for="classroom_id">

                <select class="form-control form-control-lg" name="classroom_id" id="sign-up-classroom"></select>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="submit" value="Sign Up" class="btn btn-primary btn-block"/>
        </div>
        <span class="sign-in">Already a member? <a href="{{ route('login') }}">Log In</a></span>
    </div>
</form>
