/**
 * Created by jonn on 12/02/2017.
 */

var points = $(".sw-js-points");

if(points !== undefined) {
    var points_offset = points.offset().top - 50;
}

$(document).ready(function() {

    $('form').find('input,textarea,select').on("change paste keyup", function() {
        var array = [];
        var all = true;

        $(this).parents('form').find('input.sw-js-validation').map(function() {
            if($(this).attr('required')) {
                array.push(this.name);
            }
        });

        $(this).parents('form').find('textarea.sw-js-validation').map(function() {
            if($(this).attr('required')) {
                array.push(this.name);
            }
        });

        $(this).parents('form').find('select.sw-js-validation').map(function() {
            if($(this).attr('required')) {
                array.push(this.name);
            }
        });

        for(var item in array) {
            var key = $('[name='+ array[item] +']');

            if(!key.val()) {
                all = false;
            }
        }

        if(all) {
            $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
        } else {
            $(this).parents('form').find('.sw-js-submit').addClass('sw-is-unclickable').removeClass('sw-is-clickable').prop('disabled', true);
        }
    });

    $(".sw-js-radio").change(function () {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-radio-item').removeClass('sw-is-selected');
        $(this).parents('form').find('.sw-js-radio-body').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-true').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-radio-item').addClass('sw-is-selected');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-body').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-radio-item').find('.sw-js-radio-false').addClass('sw-is-hidden');

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-random-number").click(function() {
        var type = $(this).attr('data-roll-type');
        var times = $(this).attr('data-rolls');

        var result = rollNumber(type, times);

        $(this).parents('form').find('input[type=number]').val(result);
        $(this).parents('form').find('.sw-js-random-value').text(result);

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-random-radio").click(function() {
        var array = [];

        $(this).parents('form').find('input[type=radio]').map(function() {
            array.push(this.id);
        });

        var item = '#' + array[Math.floor(Math.random()*array.length)];

        $(item).change();

        var header = $(item).parents('.sw-js-radio-item').find('.sw-js-radio-title').text();
        var description = $(item).parents('.sw-js-radio-item').find('.sw-js-radio-info').text();

        $(this).parents('form').find('.sw-js-random-title').text(header);
        $(this).parents('form').find('.sw-js-random-info').text(description);

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-viewmore").click(function() {
        if($(this).find('.sw-js-chevron-up').hasClass('sw-is-hidden')) {
            $(this).find('.sw-js-chevron-up').removeClass('sw-is-hidden');
            $(this).find('.sw-js-chevron-down').addClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-view-content').removeClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-randomizer').addClass('sw-is-hidden');
            $(this).find('.sw-js-view-text').text('leave it to chance');
        } else {
            $(this).find('.sw-js-chevron-up').addClass('sw-is-hidden');
            $(this).find('.sw-js-chevron-down').removeClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-view-content').addClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-randomizer').removeClass('sw-is-hidden');
            $(this).find('.sw-js-view-text').text('decide yourself');
        }
    });

    $(".sw-js-purchase-button").click(function() {
        var pointsText = $(this).parents('body').find('.sw-js-points-text');
        var pointsInput = $(this).parents('body').find('.sw-js-points-input');

        var pointsTextValue = parseInt(pointsText.text());

        var buttonInput = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-input');
        var buttonInputValue = parseInt(buttonInput.val());

        var buttonValueText = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-value');

        var purchaseMin = parseInt(buttonInput.attr('min'));
        var purchaseMax = parseInt(buttonInput.attr('max'));

        if($(this).hasClass('sw-js-purchase-plus') && buttonInputValue !== purchaseMax) {
            var p = parseInt(pointsTextValue);

            buttonInputValue++;

            var i = parseInt(buttonInputValue);

            pointsTextValue = p-i;
        }

        if($(this).hasClass('sw-js-purchase-minus') && buttonInputValue !== purchaseMin) {
            var p = parseInt(pointsTextValue);
            var i = parseInt(buttonInputValue);

            pointsTextValue = parseInt(p+i);

            buttonInputValue--;
        }

        pointsText.text(pointsTextValue);
        pointsInput.val(pointsTextValue);

        buttonValueText.text(buttonInputValue);
        buttonInput.val(buttonInputValue);

        if(pointsTextValue >= 0 || pointsTextValue === 0) {
            if(pointsText.hasClass('sw-is-invalid')) {
                pointsText.removeClass('sw-is-invalid');
            }
            $(this).parents('form').find('.sw-js-submit').prop('disabled', false);
        } else {
            pointsText.addClass('sw-is-invalid');
            $(this).parents('form').find('.sw-js-submit').prop('disabled', true);
        }
    });

    $(".sw-js-checkbox-input").change(function() {

        if ($(this).is(':checked')) {
            $(this).parents('.sw-js-checkbox-item').addClass('sw-is-selected');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-body').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-true').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-false').addClass('sw-is-hidden');
        } else {
            $(this).parents('.sw-js-checkbox-item').removeClass('sw-is-selected');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-body').addClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-true').addClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-false').removeClass('sw-is-hidden');
        }

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-checkbox-all").change(function() {

        if ($(this).is(':checked')) {
            $(this).parents('.sw-js-checkbox-item').addClass('sw-is-selected');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-true').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-false').addClass('sw-is-hidden');

            $(this).parents('form').find('.sw-js-checkbox-input').attr('checked', true).prop('checked', true);
            $(this).parents('form').find('.sw-js-checkbox-item').addClass('sw-is-selected');
            $(this).parents('form').find('.sw-js-checkbox-true').removeClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-checkbox-false').addClass('sw-is-hidden');
        } else {
            $(this).parents('.sw-js-checkbox-item').removeClass('sw-is-selected');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-true').addClass('sw-is-hidden');
            $(this).parents('.sw-js-checkbox-item').find('.sw-js-checkbox-false').removeClass('sw-is-hidden');

            $(this).parents('form').find('.sw-js-checkbox-input').attr('checked', false).prop('checked', false);
            $(this).parents('form').find('.sw-js-checkbox-item').removeClass('sw-is-selected');
            $(this).parents('form').find('.sw-js-checkbox-true').addClass('sw-is-hidden');
            $(this).parents('form').find('.sw-js-checkbox-false').removeClass('sw-is-hidden');
        }

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-pick-input").change(function() {
        $(this).attr('checked', true);

        $(this).parents('.sw-js-pick').find('.sw-js-pick-true').addClass('sw-is-hidden');
        $(this).parents('.sw-js-pick').find('.sw-js-pick-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-pick-item').find('.sw-js-pick-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-pick-item').find('.sw-js-pick-false').addClass('sw-is-hidden');
    });

    $(".sw-js-icon-radio").change(function() {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-icon-item').removeClass('sw-is-selected');
        $(this).parents('label').find('.sw-js-icon-item').addClass('sw-is-selected');
        console.log();
    });

});

$(window).scroll(function() {

    if(points !== undefined) {
        if($(this).scrollTop() > points_offset && !points.hasClass('sw-c-points--position')) {
            points.addClass('sw-c-points--position');
        }

        if($(this).scrollTop() < points_offset && points.hasClass('sw-c-points--position')) {
            points.removeClass('sw-c-points--position');
        }
    }
});

function rollNumber(type, times) {
    var dice = parseInt(times);

    var roll = 0;
    var result = 0;

    for (var i = 0; i < dice; i++) {
        roll = Math.floor((Math.random() * 12) + 1);

        if (type == 'Money') {
            if (roll == 12) { result = result + 2 }
            if (roll == 11) { result = result + 1 }
            if (roll == 10) { result = result + 1 }
            if (roll ==  9) { result = result - 1 }
        }

        if (type == 'Honor' || type == 'Infamy') {
            if (roll == 12) { result = result + 2 }
            if (roll == 11) { result = result + 1 }
            if (roll == 10) { result = result + 1 }
            if (roll ==  9) { result = result + 1 }
        }

        if (type == 'Potential') {
            result = roll;
        }
    }

    return result;
}

function rollRelationship(times) {
    var dice = parseInt(times);

    var acceptance;
    var influence;
    var roll = 0;

    for (var i = 0; i < dice; i++) {
        roll = Math.floor((Math.random() * 12) + 1);

        if (roll > 8) { influence = Math.floor((Math.random() * 12) + 1); }

        if (roll == 12) { acceptance = 'Loyal'; }
        if (roll == 11) { acceptance = 'Friendly'; }
        if (roll == 10) { acceptance = 'Opposed'; }
        if (roll ==  9) { acceptance = 'Hostile'; }
    }

    return [acceptance, influence];
}
