@extends('layouts.page')

@section('content')

<div class="full top">

    <div class="contain">

        <nav class="nav logged-out">
            <ul>
                <li><a href="#">Projects <i class="icon icon-open-dd"></i></a></li>
                <li><a href="#">Meet The Lab</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>

        <a href="{{ route('login') }}" class="btn btn-login" id="login">Log In</a>

    </div>

</div>

<header class="full">

    <div class="contain">

        <h1>The<br>Early Science<br>Initiative - Project 2</h1>

        <img src="{{ app('request')->root() }}/img/ESI_greeting.gif" width="171" height="99">

    </div>

</header>

<div class="full">

    <section class="contain content">

        <article class="module">

            <h2 class="third-bg">Create An Account</h2>

            <div class="module-content">

                @include('auth/signup')

            </div>

        </article>

        <article class="intro">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p>

            <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>

            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p>

        </article>

    </section>

</div>

@endsection
