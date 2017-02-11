/**
 * Created by jonn on 10/02/2017.
 */

var roll_d12, roll_bonus, strike_d12, strike_bonus, strike_critical;

$(document).ready(function(){

    $(".sw-js-radio").change(function() {
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

        $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
    });

    $(".sw-js-input-radio").change(function() {
        $(this).attr('checked', true);

        $(this).parents('form').find('.sw-js-radio-true').addClass('sw-is-hidden');
        $(this).parents('form').find('.sw-js-radio-false').removeClass('sw-is-hidden');

        $(this).parents('.sw-js-input-item').find('.sw-js-radio-true').removeClass('sw-is-hidden');
        $(this).parents('.sw-js-input-item').find('.sw-js-radio-false').addClass('sw-is-hidden');

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

    $(".sw-js-view-button").click(function() {
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

        var pointsTextValue = pointsText.text();

        var buttonInput = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-input');
        var buttonInputValue = buttonInput.val();

        var buttonValueText = $(this).parents('.sw-js-purchase-item').find('.sw-js-purchase-value');

        var purchaseMin = buttonInput.attr('min');
        var purchaseMax = buttonInput.attr('max');

        if($(this).hasClass('sw-js-purchase-plus') && buttonInputValue != purchaseMax) {
            var p = parseInt(pointsTextValue);

            buttonInputValue++;

            var i = parseInt(buttonInputValue);

            pointsTextValue = p-i;
        }

        if($(this).hasClass('sw-js-purchase-minus') && buttonInputValue != purchaseMin) {
            var p = parseInt(pointsTextValue);
            var i = parseInt(buttonInputValue);

            pointsTextValue = parseInt(p+i);

            buttonInputValue--;
        }

        pointsText.text(pointsTextValue);
        pointsInput.val(pointsTextValue);

        buttonValueText.text(buttonInputValue);
        buttonInput.val(buttonInputValue);

        if(pointsTextValue >= 0) {
            $(this).parents('form').find('.sw-js-submit').removeClass('sw-is-unclickable').addClass('sw-is-clickable').prop('disabled', false);
        } else {
            $(this).parents('form').find('.sw-js-submit').addClass('sw-is-unclickable').removeClass('sw-is-clickable').prop('disabled', true);
        }
    });

    $(".sw-js-roll-button").click(function() {
        var type = $(this).attr('data-roll-type');

        roll_d12 = $(this).attr('data-roll-d12');
        roll_bonus = $(this).attr('data-roll-bonus');
        strike_d12 = $(this).attr('data-strike-d12');
        strike_bonus = $(this).attr('data-strike-bonus');
        strike_critical = $(this).attr('data-strike-critical');

        $('.sw-js-modal-title').text($(this).find('.sw-js-button-title').text());
        $('.sw-js-modal-description').html($(this).find('.sw-js-button-information').html());

        switch(type) {
            case 'default':
                modalDisplayRoll();
                modalDefaultButtons();
                break;

            case 'consumable':
                modalDisplayRoll();
                modalConsumableButtons();
                break;

            case 'supernatural':
                modalDisplayRoll();
                modalSupernaturalButtons();
                break;

            case 'weapon':
                modalDisplayRoll();
                modalWeaponButtons();
                break;
        }

        modalOpen();
    });

    $(".sw-js-list-header").click(function() {

        if($(this).parents('.sw-js-list-item').hasClass('sw-is-selected--gray')) {

            $(this).parents('.sw-js-list-item').find('.sw-js-list-information').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').find('.sw-js-chevron-down').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').find('.sw-js-chevron-up').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').removeClass('sw-is-selected--gray');

        } else {

            $(this).parents('body').find('.sw-js-list-information').addClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-chevron-up').addClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-chevron-down').removeClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-list-item').removeClass('sw-is-selected--gray');

            $(this).parents('.sw-js-list-item').find('.sw-js-list-information').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').find('.sw-js-chevron-down').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').find('.sw-js-chevron-up').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list-item').addClass('sw-is-selected--gray');

        }

    });

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

    $(".sw-js-modal-info").click(function() {
        modalDisplayInfo();
    });

    $(".sw-js-modal-close").click(function() {
        modalClose();
    });

    $(".sw-js-modal-roll").click(function() {
        modalDisplayRoll();
        modalRollDefault(roll_d12, roll_bonus);
    });

    $(".sw-js-modal-consumable").click(function() {
        modalDisplayRoll();
        modalRollConsumable(roll_d12);
    });

    $(".sw-js-modal-supernatural").click(function() {
        modalDisplayRoll();
        modalRollSupernatural(strike_d12);
    });

    $(".sw-js-modal-weapon").click(function() {
        modalDisplayRoll();
        modalRollWeapon(strike_d12, strike_bonus, strike_critical);
    });

    $(".sw-js-mask").click(function() {
        modalClose();
    });

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

function modalRollDice(times, tellMe) {
    var dice = parseInt(times);

    var roll = 0;
    var result = 0;
    var critical = false;

    for (var i = 0; i < dice; i++) {
        roll = Math.floor((Math.random() * 12) + 1);
        result = result + roll;

        if (roll == 12 || roll == 1) {
            critical = true;
        }

        if(tellMe) {
            $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + roll);

            if(i < dice-1) {
                $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' + ');
            }
        }
    }

    return [result,critical];
}

function modalRollDefault(rollD12, rollBonus) {
    $('.sw-js-modal-with').html("Rolling with " + rollD12 + "d12+" + rollBonus);

    var bonus = parseInt(rollBonus);
    var modifier = parseInt($('.sw-js-roll-modifier').text());
    var resultArray = modalRollDice(parseInt(rollD12), true);
    var result = resultArray[0];
    var critical = resultArray[1];

    if (!bonus == 0) {
        result = result + bonus;
        $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' (+' + bonus + ')');
    }

    if(!modifier == 0) {
        result = result + modifier;
        $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' (+' + modifier + ')');
    }

    if (critical) {
        $('.sw-js-modal-critical').html("- DC Critical -");
        $('.sw-js-saved-critical').text(1);
    } else {
        $('.sw-js-modal-critical').html("&nbsp;");
        $('.sw-js-saved-critical').text(0);
    }

    $('.sw-js-modal-result').html(result);
}

function modalRollConsumable(rollD12) {
    $('.sw-js-modal-with').html("Rolling with " + rollD12 + "D12");

    var d12 = parseInt(rollD12);
    var result = 0;
    var roll = 0;

    for (var i = 0; i < d12; i++) {
        roll = Math.floor((Math.random() * 12) + 1);

        if (roll == 1) {
            result = 'failed';
        }

        $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + roll);

        if(i < d12-1) {
            $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' + ');
        }
    }

    if (result == 0) { result = 'safe'; }

    $('.sw-js-modal-result').html(result);
}

function modalRollSupernatural(strikeD12) {
    $('.sw-js-modal-with').html("Rolling with " + strikeD12 + "D12");

    var amount = 0;
    var critical = parseInt($('.sw-js-saved-critical').text());

    if (critical == 1) {
        $('.sw-js-modal-critical').html("- DC Critical -");
        amount = parseInt(strikeD12) * 2;
    } else {
        $('.sw-js-modal-critical').html("&nbsp;");
        amount = parseInt(strikeD12);
    }

    var resultArray = modalRollDice(amount, true);
    var result = resultArray[0];

    $('.sw-js-modal-result').html(result);
}

function modalRollWeapon(strikeD12, strikeBonus, strikeCritical) {
    $('.sw-js-modal-with').html("Rolling with " + strikeD12 + "D12+" + strikeBonus);

    var resultArray = modalRollDice(parseInt(strikeD12), true);
    var result = resultArray[0];

    var bonus = parseInt(strikeBonus);

    if (!bonus == 0) {
        result = result + bonus;
        $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' (+' + bonus + ')');
    }

    var critical = parseInt($('.sw-js-saved-critical').text());

    if(critical) {
        $('.sw-js-modal-critical').html("- DC Critical -");

        var critArray = modalRollDice(parseInt(strikeCritical), false);
        result = result + critArray[0];

        $('.sw-js-modal-count').html($('.sw-js-modal-count').html() + ' (+' + critArray[0] + ')');
    } else {
        $('.sw-js-modal-critical').html("&nbsp;");
    }

    $('.sw-js-modal-result').html(result);
}

function modalClearRoll() {
    $('.sw-js-modal-with').html("&nbsp;");
    $('.sw-js-modal-result').html("&nbsp;");
    $('.sw-js-modal-critical').html("Press the dice to roll");
    $('.sw-js-modal-count').html("&nbsp;");
}

function modalDisplayInfo() {
    $('.sw-js-modal-with').addClass('sw-is-hidden');
    $('.sw-js-modal-result').addClass('sw-is-hidden');
    $('.sw-js-modal-critical').addClass('sw-is-hidden');
    $('.sw-js-modal-count').addClass('sw-is-hidden');

    $('.sw-js-modal-info').removeClass('sw-is-hidden');
}

function modalDisplayRoll() {
    modalClearRoll();

    $('.sw-js-modal-with').removeClass('sw-is-hidden');
    $('.sw-js-modal-result').removeClass('sw-is-hidden');
    $('.sw-js-modal-critical').removeClass('sw-is-hidden');
    $('.sw-js-modal-count').removeClass('sw-is-hidden');

    $('.sw-js-modal-description').addClass('sw-is-hidden');
}

function modalClose() {
    $('.sw-js-modal-with').innerHTML = "&nbsp;";
    $('.sw-js-modal-result').innerHTML = "&nbsp;";
    $('.sw-js-modal-critical').innerHTML = "Press the dice to roll";
    $('.sw-js-modal-count').innerHTML = "&nbsp;";
    $('.sw-js-modal-info').innerHTML = "&nbsp;";

    $('.sw-js-mask').addClass('sw-is-hidden');
    $('.sw-js-modal').addClass('sw-is-hidden');

    $('.sw-js-saved-critical').text(0);
}

function modalOpen() {
    $('.sw-js-mask').removeClass('sw-is-hidden');
    $('.sw-js-modal').removeClass('sw-is-hidden');

    $('.sw-js-modal').css('top', ($(window).height()/2) - ($('.sw-js-modal').height()/2));
    $('.sw-js-modal').css('left', ($(window).width()/2) - ($('.sw-js-modal').width()/2));
}

function modalDefaultButtons() {
    $('.sw-js-modal-roll').removeClass('sw-is-hidden');

    $('.sw-js-modal-consumable').addClass('sw-is-hidden');
    $('.sw-js-modal-supernatural').addClass('sw-is-hidden');
    $('.sw-js-modal-weapon').addClass('sw-is-hidden');
}

function modalConsumableButtons() {
    $('.sw-js-modal-consumable').removeClass('sw-is-hidden');

    $('.sw-js-modal-roll').addClass('sw-is-hidden');
    $('.sw-js-modal-supernatural').addClass('sw-is-hidden');
    $('.sw-js-modal-weapon').addClass('sw-is-hidden');
}

function modalSupernaturalButtons() {
    $('.sw-js-modal-roll').removeClass('sw-is-hidden');
    $('.sw-js-modal-supernatural').removeClass('sw-is-hidden');

    $('.sw-js-modal-consumable').addClass('sw-is-hidden');
    $('.sw-js-modal-weapon').addClass('sw-is-hidden');
}

function modalWeaponButtons() {
    $('.sw-js-modal-roll').removeClass('sw-is-hidden');
    $('.sw-js-modal-weapon').removeClass('sw-is-hidden');

    $('.sw-js-modal-consumable').addClass('sw-is-hidden');
    $('.sw-js-modal-supernatural').addClass('sw-is-hidden');
}