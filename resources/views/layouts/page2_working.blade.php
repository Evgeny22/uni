<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.medium-editor-head')
    <link href="{{ app('request')->root() }}/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ app('request')->root() }}/js/jquery.min.js" type="text/javascript"></script>
    <script src="{{ app('request')->root() }}/js/bootstrap.min.js" type="text/javascript"></script>
    @yield('css')
</head>

<body>
@yield('content')

@yield('js')
</body>
</html>
