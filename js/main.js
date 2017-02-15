/**
 * Created by jonn on 15/02/2017.
 */

$(document).ready(function(){

    $(".sw-js-menu").click(function() {

        if($(this).text() == 'Play') {
            $('.sw-js-menu-view').addClass('sw-is-hidden');
            $('.sw-js-menu-play').removeClass('sw-is-hidden');
        }

        if($(this).text() == 'View') {
            $('.sw-js-menu-play').addClass('sw-is-hidden');
            $('.sw-js-menu-view').removeClass('sw-is-hidden');
        }

        $(".sw-js-menu-mask").removeClass('sw-is-hidden');

    });

    $(".sw-js-menu-mask").click(function() {

        $('.sw-js-menu-play').addClass('sw-is-hidden');
        $('.sw-js-menu-view').addClass('sw-is-hidden');
        $(".sw-js-menu-mask").addClass('sw-is-hidden');

    });

});
