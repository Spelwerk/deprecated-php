/**
 * Created by jonn on 13/02/2017.
 */

$(document).ready(function(){

    $('form').find('input,textarea,select').on("change paste keyup", function() {
        var validPass = false;

        var pass1 = $('input[name="user--password"]').val();
        var pass2 = $('input[name="user--password2"]').val();

        /** password validation */

        if(pass1 == pass2 && pass1 != '' && pass2 != '') {
            validPass = true;
            $('.sw-js-password-validation').addClass('sw-is-hidden');
        } else {
            validPass = false;

            if(pass1 == '' && pass2 == '') {
                $('.sw-js-password-validation').addClass('sw-is-hidden');
            } else {
                $('.sw-js-password-validation').removeClass('sw-is-hidden').text('Password does not match');
            }
        }

        /** final verdict */

        if(validPass) {
            $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
        } else {
            $(this).parents('form').find('.sw-js-submit').addClass('sw-is-unclickable').removeClass('sw-is-clickable').prop('disabled', true);
        }

    });

});