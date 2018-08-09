@extends('layouts.page')

@section('content')

    <div class="full top">
        <div class="contain">
            <a href="{{ route('signup') }}" class="btn btn-action" id="sign-up">Sign Up</a>
        </div>
    </div>
    ​
    <header class="full">
        <div class="contain">
            <h1>The Early Science Initiative</h1>
        </div>
    </header>
    ​
    <div class="full">
        <section class="contain content">
            <article class="module">
                <h2 class="primary-bg">{{$set == 1 ? "Set Password" : "Reset Password"}}</h2>
                <div class="module-content">
                    @include('auth/reset',['set'=>$set])
                </div>
            </article>
        </section>
    </div>

@endsection
