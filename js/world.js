/**
 * Created by jonn on 15/02/2017.
 */

$(document).ready(function() {

    $(".sw-js-radio").change(function () {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-radio-item').removeClass('sw-is-selected');
        $(this).parents('form').find('.sw-js-radio-info').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-true').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-radio-item').addClass('sw-is-selected');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-info').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-false').addClass('sw-is-hidden');

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-check").change(function () {

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

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-input-radio").change(function () {
        $(this).attr('checked', true);

        $(this).parents('.sw-js-bool').find('.sw-js-radio-true').addClass('sw-is-hidden');
        $(this).parents('.sw-js-bool').find('.sw-js-radio-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-input-item').find('.sw-js-radio-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-input-item').find('.sw-js-radio-false').addClass('sw-is-hidden');

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

});