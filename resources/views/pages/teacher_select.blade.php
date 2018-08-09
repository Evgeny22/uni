@include('includes/header')

<section class="teacher-select-list component">

    <div class="row">

        <article class="module">

            <h2>Teacher List</h2>

            <div class="module-content pad-wide">

                <div class="row">

                    @include('teacher_select_list', [
                      'list' => $teacher_list,
                    ])

                </div>

            </div>

        </article>

    </div>

</section>


@include('includes/footer')
