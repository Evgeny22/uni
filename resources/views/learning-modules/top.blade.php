<div class="row component-top">
    @if ($user->is('super_admin'))
    <div class="button">

        <a href="#" class="btn btn-action" data-trigger="new-post">Add a Learning Module +</a>

    </div>
    @endif

    <div class="options">

        @if ($page == 'learning-module')
        <div class="go-back">

            <h3><a href="{{ route ('learning-modules.index') }}">&lt; Learning Modules</a></h3>

        </div>
        @else
        <div class="sort">

            <h3><a href="#">@if (app('request')->input('sort') == 'asc') Oldest First @else Most Recent @endif<i class="icon icon-open-dd"></i></a></h3>

        </div>
        @endif

        <!--<div class="search">

            <select name="search-by-title-and-author" class="search-by"><option></option></select>

        </div>-->

    </div>

</div>