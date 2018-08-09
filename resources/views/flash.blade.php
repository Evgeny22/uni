@if ( Session::has('flash.message') )

    {{--<div id="popup-flash">

        <article class="module">

            <h2 class="{{ Session::get('flash.component') }}-bg">{{ Session::get('flash.title') }}</h2>

            <div class="module-content">

                <div class="full"><i class="icon {{ Session::get('flash.title') == 'Error' ? "icon-x error" : "icon-check" }}"></i></div>

                {{ Session::get('flash.message') }}

                <div class="modal-footer" style="text-align: center; padding: 0;">
                <button name="action" value="cancel" class="btn btn-primary btn-cancel">Close</button>
                </div>

            </div>

        </article>

    </div>--}}

    <!-- Modal -->

    <!-- Modal -->
    @if (Session::get('flash.status') == 'uploaded')
    <div id="popup-flash" class="modal fade animated" aria-hidden="true" role="dialog" style="display: none;" data-keyboard="false" data-backdrop="static">
    @else
    <div id="popup-flash" class="modal fade animated" aria-hidden="true" role="dialog" style="display: none;">
    @endif
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @if (Session::get('flash.title') == 'Error')
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">×</button>
                    </div>
                @else
                    <div class="modal-header">
                @endif
                        @if (Session::get('flash.status') == 'uploaded')
                        @else
                            <button class="close" data-dismiss="modal" type="button">×</button>
                        @endif
                        <h4 class="modal-title">{{ Session::get('flash.title') }}</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                {{ Session::get('flash.message') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group pull-right" role="group" aria-label="Actions">
                            @if (Session::get('flash.status') == 'uploaded')
                            <button type="submit" class="btn btn-primary" onClick="window.location.reload()">
                                Get Started
                            </button>
                            @else
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">
                                Dismiss
                            </button>
                            @endif
                        </div>

                    </div>
            </div>
        </div>
    </div>
    <!-- / Share Object Modal -->
@endif