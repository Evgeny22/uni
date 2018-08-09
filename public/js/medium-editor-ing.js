jQuery(document).ready(function($){
/*
    var editor = new MediumEditor('.editable');

    $('.editable').mediumInsert({
        editor: editor
    });

    $('.form-new-message').on('submit', function(e){
        $('#message-content').attr('value', editor.serialize()['element-0'].value);
    })
    */
    $('form').submit(function(e) {
        $(this).formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'div error',
            onSuccess: function (form) {
                return true;
            },
            onFailure: function(form){
                e.preventDefault();
                return false;
            },
            localization: {
                en: {
                    failure: {
                        title: function(title, value, name, input) {
                            return 'There is no way that email ' + value + ' is valid.';
                        }
                    }
                }}
        });
    });
});