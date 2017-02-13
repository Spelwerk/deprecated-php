/**
 * Created by jonn on 12/02/2017.
 */

$(document).ready(function(){

    $('form').find('input').on("change paste keyup", function() {
        var array = [];

        var validGeneral = true;
        var validMail = false;

        var rfc2822 = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;

        var mail = $('input[name="user--email"]').val();

        /** email validation */

        if(mail) {
            if(rfc2822.test(mail)) {
                validMail = true;
                $(".sw-js-email-validation").addClass('sw-is-hidden');
            } else {
                validMail = false;
                $(".sw-js-email-validation").removeClass('sw-is-hidden').text('Email is invalid');
            }
        }

        /** general validation */

        $(this).parents('form').find('.sw-js-validation').map(function() {
            if($(this).attr('required')) {
                array.push(this.name);
            }
        });

        for(var item in array) {
            var key = $('[name='+ array[item] +']');

            if(!key.val()) {
                validGeneral = false;
            }
        }

        /** final verdict */

        if(validMail && validGeneral) {
            $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
        } else {
            $(this).parents('form').find('.sw-js-submit').addClass('sw-is-unclickable').removeClass('sw-is-clickable').prop('disabled', true);
        }

    });

});