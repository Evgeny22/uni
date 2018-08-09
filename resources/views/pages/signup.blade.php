<!DOCTYPE html>
<html>
<head>
    @include('includes/head')
    @include('includes.medium-editor-head')
</head>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
<script src="/js/underscore.min.js"></script>
<script src="{{ app('request')->root() }}/js/jquery.tooltipster.min.js"></script>
<script src="{{ app('request')->root() }}/js/global.min.js"></script>

@include('includes.medium-editor-footer')
@include('includes.wistia-footer')
<body class="log-in">

<div class="full top">
    <div class="contain">
        <a href="{{ route('login') }}" class="btn btn-login" id="login">Log In</a>
    </div>
</div>
<header class="full">
    <div class="contain">
        <h1>The Early Science Initiative</h1>
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
    </section>
</div>