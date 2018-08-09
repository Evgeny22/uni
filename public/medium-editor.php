<html>
<head>
    <!-- CSS -->
    <link href="css/screen.css" rel="stylesheet">
    <link rel="stylesheet" href="bower_components/medium-editor/dist/css/medium-editor.min.css">
    <link rel="stylesheet" href="bower_components/medium-editor/dist/css/themes/default.css" id="medium-editor-theme">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="bower_components/medium-editor-insert-plugin/dist/css/medium-editor-insert-plugin.min.css">
</head>
<body>

<div id="container" style="max-width: 960px;
    margin: 30px auto;
    padding: 0 15px;
    background: yellow;
    height: 500px;">
    <div class="editable" data-placeholder="Type some text" style="min-height: 38px;
    margin: 0 0 20px 0;
    padding: 0 0 20px 0;
    height: 500px">

        <br>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="bower_components/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script src="bower_components/blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="bower_components/medium-editor/dist/js/medium-editor.js"></script>
<script src="bower_components/handlebars/handlebars.runtime.min.js"></script>
<script src="bower_components/jquery-sortable/source/js/jquery-sortable-min.js"></script>

<script src="bower_components/jquery-cycle2/build/jquery.cycle2.min.js"></script>
<script src="bower_components/jquery-cycle2/build/plugin/jquery.cycle2.center.min.js"></script>

<script src="bower_components/medium-editor-insert-plugin/dist/js/medium-editor-insert-plugin.min.js"></script>

<script>
    var editor = new MediumEditor('.editable', {
        buttonLabels: 'fontawesome'
    });
    $(function () {
        $('.editable').mediumInsert({
            editor: editor,
            addons: {
                images: {
                    uploadScript: null,
                    deleteScript: null,
                    styles: {
                        slideshow: {
                            label: '<span class="fa fa-play"></span>',
                            added: function ($el) {
                                $el
                                    .data('cycle-center-vert', true)
                                    .cycle({
                                        slides: 'figure'
                                    });
                            },
                            removed: function ($el) {
                                $el.cycle('destroy');
                            }
                        }
                    },
                    actions: null
                }
            }
        });
    });
</script>

</body>
</html>