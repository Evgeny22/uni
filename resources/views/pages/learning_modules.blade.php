@include('includes/header')

<div id="popup">

    @if ($user->is('super_admin'))

    <article class="module new-post">

        <h2 class="lm-bg">New Learning Module <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content">

            <form method="post" action="{{ route('learning-modules.store') }}">
                {!! csrf_field() !!}

                <input name="title" placeholder="Title">
                <input name="link" placeholder="Zoom Link">
                <textarea name="description" placeholder="Brief Description"></textarea>

                <button class="btn lm-bg" role="submit">Post</button>
                <button class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

    @endif

</div>

<section class="learning-modules component">

    <div class="row component-top">

        <div class="button">

            <a href="#" class="btn btn-action" data-trigger="new-post">Add A Learning Module +</a>

        </div>

        <div class="options">

            <div class="sort">

                <h3><a href="#">Most Recent <i class="icon icon-open-dd"></i></a></h3>

            </div>

            <div class="search">

                <input placeholder="Search by title"> <i class="icon icon-search"></i>

            </div>

        </div>

    </div>

    <div class="row">

        <article class="module full">

            <h2>Learning Moduleddds</h2>

            <div class="module-content pad-wide">
                @include('learning_modules_list', [

                    'learningModules' => $learningModulesList
                ])

            </div>

        </article>

    </div>

</section>


@include('includes/footer')
