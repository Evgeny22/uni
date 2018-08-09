console.log('user-idle.js loaded');

var idleTime = 0;

$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 5000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 5) { // 5 minutes
        // Log user out
        $.get(APP_URL +'/logout');

        alert('You have been logged out to due to inactivity. Please log in again.');

        // Refresh page
        window.location.reload();
    }
}