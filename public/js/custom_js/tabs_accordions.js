"use strict";
$(document).ready(function () {

    /* popover panel js */
    $("[data-toggle='popover']").popover();

    /* tooltops panel js */
    $(".tooltip-examples a").tooltip({
        placement: 'top'
    });

    /* popover panel fifa js */
    $('.po-markup > .po-link').popover({
        trigger: 'hover',

        html: true, // must have if HTML is contained in popover
        // get the title and conent
        title: function () {
            return $(this).parent().find('.po-title').html();
        },
        content: function () {
            return $(this).parent().find('.po-body').html();
        },
        container: 'body',
        placement: 'right'
    });
    

});
