<div class="exemplar-toggle">


    <?php if (isset($video)) $which = $video; else if (isset($lessonPlan)) $which = $lessonPlan; ?>

    @if ($which->isExemplar == true)

        @if ($user->is('super_admin'))

            <p data-trigger="exemplar-remove">Post is exemplar. Click to remove.</p>

        @else

            <p>This is an examplar.</p>

        @endif

    @elseif (isset($which->exemplar()->approved) and  $which->exemplar()->approved == false)

        @if ($user->is('super_admin'))

            <p data-trigger="exemplar-response">Pending exemplar. Click to respond.</p>

        @else

            <p>This is an examplar.</p>

        @endif

    @else

        @if ($user->is('master_teacher') or $user->is('super_admin'))

            <p data-trigger="exemplar-request">Make Exemplar</p>

        @endif

    @endif

    @if ((isset($which->exemplar()->approved) and $which->exemplar()->approved == "0") and ($user->is('super_admin') or $user->is('master_teacher')))

        <p class="exemplar-alert">*This {{isset($video) ? "video" : "instructional design"}} is pending exemplar approval</p>

    @endif

</div>