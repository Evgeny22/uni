"use strict";
$(document).ready(function () {
    // header

    // sales, visits and load sparkline chart
    // flip
    $(".flip").flip({
        trigger: 'hover'
    });

    //auto timeline update panel

    if ($('.timeline-update').length > 0) {
        $('.timeline-update').newsTicker({
            row_height: 117,
            max_rows: 4,
            speed: 2000,
            direction: 'up',
            duration: 3500,
            autostart: 1,
            pauseOnHover: 1
        });
    }

    //auto timeline update panel ends


});
