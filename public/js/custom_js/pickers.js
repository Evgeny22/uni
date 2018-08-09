"use strict";
$(document).ready(function () {


    $('.multiselect').multiselect({
        numberDisplayed: 2
    });
    $('#example2').multiselect({
        numberDisplayed: 2
    });
    $('#example27').multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 2
    });

    // Add options for example 28.
    for (var i = 1; i <= 100; i++) {
        $('#example28').append('<option value="' + i + '">' + i + '</option>');
    }

    $('#example28').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 150,
        numberDisplayed: 2
    });

    $('#example28-values').on('click', function () {
        var values = [];

        $('option:selected', $('#example28')).each(function () {
            values.push($(this).val());
        });

        alert(values);
    });

    $('#example3').multiselect({
        buttonClass: 'btn btn-link',
        numberDisplayed: 2
    });

    $('#crosscutting').multiselect({
        numberDisplayed: 2
    });
    $('#practices').multiselect({
        numberDisplayed: 2
    });
    $('#coreideas').multiselect({
        numberDisplayed: 2
    });

    $('#example9').multiselect({
        onChange: function (element, checked) {
            alert('Change event invoked!');
            console.log(element);
        },
        numberDisplayed: 2
    });

    $('#example13').multiselect({
        numberDisplayed: 2
    });

    $('#example19').multiselect({
        numberDisplayed: 1
    });

    $('#example35').multiselect({
        numberDisplayed: 2
    });
    $('#example35-enable').on('click', function () {
        $('#example35').multiselect('enable');
    });
    $('#example35-disable').on('click', function () {
        $('#example35').multiselect('disable');
    });

    $("[name='my-checkbox']").bootstrapSwitch();
//============button-size-change=======
    $(".changesize").on("click", function () {
        $("#switchsize").bootstrapSwitch("size", $(this).text());
    });
//=========Indeterminate State==========
    $('.changeindeterminate').on("click", function () {
        $('#indeterminate').bootstrapSwitch('toggleIndeterminate');
    });
//==============On Off Text==========
    $(".ontext,.offtext").on("keyup", function () {
        $('#onofftext').bootstrapSwitch('onText', $('.ontext').val());
        if ($('.ontext').val() == "") {
            $('#onofftext').bootstrapSwitch('onText', "ON");
        }
        $('#onofftext').bootstrapSwitch('offText', $('.offtext').val());
        if ($('.offtext').val() == "") {
            $('#onofftext').bootstrapSwitch('offText', "OFF");
        }
    });
});