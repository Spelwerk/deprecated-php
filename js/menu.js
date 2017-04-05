$(document).ready(function() {

    var tab = $('.sw-js-menu-tab');

    tab.click(function() {
        $('.sw-js-menu-tab').removeClass('sw-c-item--active').addClass('sw-c-item');
        $(this).addClass('sw-c-item--active');

        var id = $(this).attr('id');
        var split = id.split('__');
        var listID = split[1];
        var idName = '#list__' + listID;

        $('.sw-js-menu-links').addClass('sw-is-hidden');
        $(idName).removeClass('sw-is-hidden');
    });

});