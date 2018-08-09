<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body class="not-found">

    <article class="module">

        <h2 class="error neutral-bg">Something Went Wrong</h2>

        <div class="module-content">

            <p class="error">{{ $exception->getMessage() }}</p>

            <p><a href="{{ route ('dashboard') }}" class="btn btn-secondary">View Dashboard</a></p>

        </div>

    </article>

</body>

</html>

