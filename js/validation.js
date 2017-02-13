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

});