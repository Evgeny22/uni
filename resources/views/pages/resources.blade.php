@include('includes/header')

<div id="popup">

    <article class="module new-post">

        <h2 class="resource-bg">New Resource <span class="icon icon-expand" title="Expand this window"></span></h2>

        <div class="module-content">

            <form method="post">

                <input name="title" placeholder="Title">
                <input name="link" placeholder="Zoom Link">
                <textarea name="content" placeholder="Resource Content"></textarea>

                <button class="btn id-bg" role="submit">Post</button>
                <button class="btn btn-cancel">Cancel</button>

            </form>

        </div>

    </article>

</div>

<div class="row component-top">

    <div class="button">

        <a href="#" class="btn btn-action" data-trigger="new-post">Add New Resource Post +</a>

    </div>

</div>

@foreach ($resource_types as $type)

    <article class="module resource-type">

        <h2 class="{{ $type['key'] }}"><i class="icon icon-{{ $type['key'] }}"></i> For {{ $type['description'] }}</h2>

        <div class="module-content">

            <ul>
                <li><a href="#">Infants / Toddlers (Ages 0-3)</a> <!-- {{ route('resource', [ 'type' => $type['key'], 'ages' => '1-2' ]) }} --></li>
                <li><a href="#">Preschoolers (Ages 3-5)</a> <!-- {{ route('message', [ 'type' => $type['key'], 'ages' => '1-2' ]) }} --></li>
            </ul>

        </div>

    </article>

@endforeach


@include('includes/footer')
