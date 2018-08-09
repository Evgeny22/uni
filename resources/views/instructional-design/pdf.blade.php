<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lesson Plan</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
    <div class="page">
        <div class="page__date">
            <strong>Date: </strong>
            {{ $date }}
        </div><!--
        --><div class="page__title">
            <strong>Title: </strong>
            {{ $title }}
        </div>
        <div class="cf"></div>
        <div class="page__teacher">
            <strong>Teacher: </strong>
            {{ $teacher }}
        </div>
        <table>
            <tr class="row row--4">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Learning Objective</strong> (include a practice, crosscutting concept, &amp; core ideas):
                    </div>
                    <div class="cf"></div>
                    <div class="row__content">
                        {{ $answers->get('learning-objective') }}
                    </div>
                </td>
            </tr>
            <tr class="row row--1">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Crosscutting Concepts:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('crosscutting-concepts_patterns') ? 'Patterns, ' : '' }}
                        {{ $answers->get('crosscutting-concepts_cause-and-effect') ? 'Cause and Effect, ' : '' }}
                        {{ $answers->get('crosscutting-concepts_scale-proportion-and-quantity') ? 'Scale Proportion and Quantity' : '' }}
                        {{ $answers->get('crosscutting-concepts_structure-and-function') ? 'Structure and Function' : '' }}
                        {{ $answers->get('crosscutting-concepts_stability-and-change') ? 'Stability and Change' : '' }}
                    </div>
                </td>
            </tr>
            <tr class="row row--2">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Core Ideas:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('core-ideas_physical-science') ? 'Physical Science, ' : '' }}
                        {{ $answers->get('core-ideas_life-science') ? 'Life Science, ' : '' }}
                        {{ $answers->get('core-ideas_earth-and-space-science') ? 'Earth and Space Science, ' : '' }}
                        {{ $answers->get('core-ideas_engineering-and-technology') ? 'Engineering and Technology, ' : '' }}
                    </div>
                </td>
            </tr>
            <tr class="row row--1">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Key Practices:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('practices_observing') ? 'Observing, ' : '' }}
                        {{ $answers->get('practices_questioning') ? 'Questioning, ' : '' }}
                        {{ $answers->get('practices_predicting') ? 'Predicting, ' : '' }}
                        {{ $answers->get('practices_modeling') ? 'Modeling, ' : '' }}
                        {{ $answers->get('practices_planning') ? 'Planning, ' : '' }}
                        {{ $answers->get('practices_investigating') ? 'Investigating, ' : '' }}
                        {{ $answers->get('practices_using-math') ?  'Using Math, ' : '' }}
                        {{ $answers->get('practices_documenting-data') ? 'Documenting Data, ' : '' }}
                        {{ $answers->get('practices_analyzing-data') ?  'Analyzing Data, ' : '' }}
                        {{ $answers->get('practices_interpreting-data') ?  'Interpreting Data, ' : '' }}
                        {{ $answers->get('practices_explaining') ? 'Explaining, ' : '' }}
                        {{ $answers->get('practices_designing-solutions') ? 'Designing Solutions, ' : '' }}
                        {{ $answers->get('practices_communicating-information') ? 'Communicating Information, ' : '' }}
                    </div>
                </td>
            </tr>
            <tr class="row row--5">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Questions to assess understanding</strong> (what crosscutting concepts are being assessed with each question?):
                    </div>
                    <div class="row__content">
                        {{ $answers->get('questions-to-assess-understanding') }}
                    </div>
                </td>
            </tr>
            <tr class="row row--5">
                <td>
                    <div class="row__header">
                        <strong>Format Used:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('format-used') }}
                    </div>
                </td>
                <td>
                    <div class="row__header">
                        <strong>Key Words:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('keywords') }}
                    </div>
                </td>
            </tr>
            <tr class="row row--5">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Materials:</strong>
                    </div>
                    <div class="row__content">
                        {{ $answers->get('materials') }}
                    </div>
                </td>
            </tr>
        </table>
        <div class="copyright">
            The Early Science Initiative
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <table>
            <tr class="row row--18">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Procedure</strong> (How will you introduce the experience to children? How will you support them throughout the experience? How
                        will you summarize the learning for them? Identify the key practices within your procedure):
                    </div>
                    <div class="row__content">
                        {{ $answers->get('procedure') }}
                    </div>
                </td>
            </tr>
            <tr class="row row--5">
                <td colspan=2>
                    <div class="row__header">
                        Ideas to <strong>connect, deepen or extend</strong> the experience:
                    </div>
                    <div class="row__content">
                        {{ $answers->get('ideas') }}
                    </div>
                </td>
            </tr>
        </table>
        <div class="copyright">
            The Early Science Initiative
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <table>
            <tr class="row row--23">
                <td colspan=2>
                    <div class="row__header">
                        <strong>Notes &amp; reflections:</strong> (Did the children meet the learning objective? Why or why not? What was surprising or unexpected
                        about how children engaged in this lesson? What else did they figure out (what other crosscutting concepts, core ideas, or
                        practices)? What modifications would you make to this lesson in the future? How will you use what <i>you learned about the
                        children</i> to plan another experience?)
                    </div>
                    <div class="row__content">
                        {{ $answers->get('notes-and-reflections') }}
                    </div>
                </td>
            </tr>
        </table>
        <div class="copyright">
            The Early Science Initiative
        </div>
    </div>
</body>
</html>
