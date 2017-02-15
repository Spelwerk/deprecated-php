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

    $(".sw-js-input-radio").change(function() {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-radio-true').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-input-item').find('.sw-js-radio-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-input-item').find('.sw-js-radio-false').addClass('sw-is-hidden');
    });

});