// custom function
function cardResize(ratio) {
    var card = $('.cardResizer');
    var width = parseFloat(card.css('width'));
    var height = width * ratio;
    card.css('height', height);
};

cardResize(1);

$(document).ready(function() {

    $('.show_meals').click( function (e) {
        e.preventDefault();
        $(this).next().slideToggle(100);
    });

    $('#newCook').click( function (e) {
        e.preventDefault();
        $('#formCooker').slideToggle(100);
    });

    $(window).resize(function () {
        cardResize(1);
    });

    $('.showAddress').click( function (e) {
        e.preventDefault();
        $(this).next().slideToggle(100);
    });

    // ----- MATERIALIZE INIT -----//
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    $('select').material_select();

    $(".button-collapse").sideNav();

    $('ul.tabs').tabs();
});
