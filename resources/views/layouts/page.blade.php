<!DOCTYPE html>
<html lang="en" style="height:100%;">
<head>
    @include('includes.head')
    @include('includes.medium-editor-head')
    <link href="{{ app('request')->root() }}/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ app('request')->root() }}/js/jquery.min.js" type="text/javascript"></script>
    <script src="{{ app('request')->root() }}/js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body id="{{ $page }}" class="{{ $page }}">
<div class="preloader">
    <div class="loader_img"><img src="img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
@yield('content')

@include('includes.medium-editor-footer')
@include('includes.wistia-footer')

</body>
</html>
