<!-- resources/views/auth/password.blade.php -->

<form action="/password/email" class="forgot_Form text-center" method="POST" id="forgot_password">
    {!! csrf_field() !!}
    <div class="form-group errors">

    </div>
    <div class="form-group">
        <input type="email" class="form-control email required" name="email" id="email" placeholder="E-mail" value="{{ old('email') }}">
    </div>
    <button type="submit" value="Reset Your Password" class="btn submit-btn btn btn-warning btn-block">
        Reset Password
    </button>
</form>