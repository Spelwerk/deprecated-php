/**
 * Created by jonn on 12/02/2017.
 */

$(document).ready(function(){

    $('form').find('input').on("change paste keyup", function() {
        var array = [];
        var valid = true;

        /** general validation */

        $(this).parents('form').find('.sw-js-validation').map(function() {
            if($(this).attr('required')) {
                array.push(this.name);
            }
        });

        for(var item in array) {
            var key = $('[name='+ array[item] +']');

            if(!key.val()) {
                valid = false;
            }
        }

        /** final verdict */

        if(valid) {
            $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
        } else {
            $(this).parents('form').find('.sw-js-submit').addClass('sw-is-unclickable').removeClass('sw-is-clickable').prop('disabled', true);
        }

    });

    $(".sw-js-pick-input").change(function() {
        $(this).attr('checked', true);

        $(this).parents('.sw-js-pick').find('.sw-js-pick-true').addClass('sw-is-hidden');
        $(this).parents('.sw-js-pick').find('.sw-js-pick-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-pick-item').find('.sw-js-pick-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-pick-item').find('.sw-js-pick-false').addClass('sw-is-hidden');
    });

    $(".sw-js-check").change(function() {

        if ($(this).is(':checked')) {
            $(this).parents('.sw-js-check-item').addClass('sw-is-selected');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-info').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-true').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-false').addClass('sw-is-hidden');
        } else {
            $(this).parents('.sw-js-check-item').removeClass('sw-is-selected');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-info').addClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-true').addClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-false').removeClass('sw-is-hidden');
        }
    });

    $(".sw-js-check-all").change(function() {

        if ($(this).is(':checked')) {
            $(this).parents('.sw-js-check-item').addClass('sw-is-selected');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-true').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-false').addClass('sw-is-hidden');

            $(this).parents('form').find('.sw-js-check').attr('checked', true);
            $(this).parents('form').find('.sw-js-check').prop('checked', true);
            $(this).parents('form').find('.sw-js-check-item').addClass('sw-is-selected');
            $(this).parents('form').find('.sw-js-check-true').removeClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-check-false').addClass('sw-is-hidden');
        } else {
            $(this).parents('.sw-js-check-item').removeClass('sw-is-selected');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-true').addClass('sw-is-hidden');
            $(this).parents('.sw-js-check-item').find('.sw-js-check-false').removeClass('sw-is-hidden');

            $(this).parents('form').find('.sw-js-check').attr('checked', false);
            $(this).parents('form').find('.sw-js-check').prop('checked', false);
            $(this).parents('form').find('.sw-js-check-item').removeClass('sw-is-selected');
            $(this).parents('form').find('.sw-js-check-true').addClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-check-false').removeClass('sw-is-hidden');
        }
    });

    $(".sw-js-icon-radio").change(function() {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-icon-item').removeClass('sw-is-selected');
        $(this).parents('label').find('.sw-js-icon-item').addClass('sw-is-selected');
        console.log();
    });

});