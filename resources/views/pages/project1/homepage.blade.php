@extends('layouts.page')

@section('content')

<div class="full top">

    <div class="contain">

        <a href="{{ route('login') }}" class="btn btn-login" id="login">Log In</a>

    </div>

</div>

<header class="full">

    <div class="contain">

        <h1>The<br>Early Science<br>Initiative</h1>

        <img src="{{ app('request')->root() }}/img/ESI_greeting.gif" width="171" height="99">

    </div>

</header>

<div class="full">

    <section class="contain content">

        <article class="module">

            <h2 class="third-bg">Create A Family Account</h2>

            <div class="module-content">

                @include('auth/signup')

            </div>

        </article>

        <article class="intro">

            <p>Science is everywhere! You can see it in the classroom when children build structures in the block area. You can find it in the sticky mess from a child’s melted Popsicle. You can feel it with the changing temperature as winter approaches.</p>

            <p>The early science initiative is about leveraging these naturally occurring science experiences to promote high-quality teaching and learning in early childhood classrooms.</p>

            <img src="{{ app('request')->root() }}/img/ESI_logos.png" alt="Buffet Early Childhood Fund - Univerysity of Miami - The Ounce - Educare Learning Network" class="intro-logos">

            <p class="funded-by">Funded by the Buffet Early Childhood Fund in collaboration with the University of Miami, the Ounce of Prevention, and the Educare Learning Network.</p>

        </article>

    </section>

</div>

<div class="full white-bg">

    <section class="content content">



    </section>

</div>

@endsection
