/**
 * Created by jonn on 15/02/2017.
 */

$(document).ready(function() {

    $(".sw-js-purchase-button").click(function () {
        var buttonInput = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-input');
        var buttonInputValue = buttonInput.val();
        var buttonValueText = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-value');

        var purchaseMin = buttonInput.attr('min');
        var purchaseMax = buttonInput.attr('max');

        if ($(this).hasClass('sw-js-purchase-plus') && buttonInputValue != purchaseMax) {
            buttonInputValue++;
        }

        if ($(this).hasClass('sw-js-purchase-minus') && buttonInputValue != purchaseMin) {
            buttonInputValue--;
        }

        buttonValueText.text(buttonInputValue);
        buttonInput.val(buttonInputValue);
    });

});