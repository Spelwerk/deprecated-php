/**
 * Created by jonn on 10/02/2017.
 */

var roll_d12, roll_bonus, strike_d12, strike_bonus, strike_critical;

$(document).ready(function(){

    document.title = "Spelwerk: " + $(".sw-js-person-name").text();

    $(".sw-js-list-head").click(function() {

        if($(this).parents('.sw-js-list').hasClass('sw-is-highlighted')) {

            $(this).parents('.sw-js-list').find('.sw-js-list-body').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list').find('.sw-js-list-chevron-down').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list').find('.sw-js-list-chevron-up').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list').removeClass('sw-is-highlighted');

        } else {

            $(this).parents('body').find('.sw-js-list-body').addClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-list-chevron-up').addClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-list-chevron-down').removeClass('sw-is-hidden');
            $(this).parents('body').find('.sw-js-list').removeClass('sw-is-highlighted');

            $(this).parents('.sw-js-list').find('.sw-js-list-body').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list').find('.sw-js-list-chevron-down').addClass('sw-is-hidden');
            $(this).parents('.sw-js-list').find('.sw-js-list-chevron-up').removeClass('sw-is-hidden');
            $(this).parents('.sw-js-list').addClass('sw-is-highlighted');

        }

    });

    $(".sw-js-roll").click(function() {
        var type = $(this).attr('data-roll-type');

        roll_d12 = $(this).attr('data-roll-d12');
        roll_bonus = $(this).attr('data-roll-bonus');
        strike_d12 = $(this).attr('data-strike-d12');
        strike_bonus = $(this).attr('data-strike-bonus');
        strike_critical = $(this).attr('data-strike-critical');

        $('.sw-js-modal-title').text($(this).find('.sw-js-roll-title').text());
        $('.sw-js-modal-description').html($(this).find('.sw-js-roll-text').html());

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

    $(".sw-js-modal-mask").click(function() {
        modalClose();
    });

    $(".sw-js-bookmark").click(function(e) {
        e.preventDefault();
        var bookmarkURL = window.location.href;
        var bookmarkTitle = document.title;

        if ('addToHomescreen' in window && window.addToHomescreen.isCompatible) {
            // Mobile browsers
            addToHomescreen({ autostart: false, startDelay: 0 }).show(true);
        } else if (window.sidebar && window.sidebar.addPanel) {
            // Firefox version < 23
            window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
        } else if ((window.sidebar && /Firefox/i.test(navigator.userAgent)) || (window.opera && window.print)) {
            // Firefox version >= 23 and Opera Hotlist
            $(this).attr({
                href: bookmarkURL,
                title: bookmarkTitle,
                rel: 'sidebar'
            }).off(e);
            return true;
        } else if (window.external && ('AddFavorite' in window.external)) {
            // IE Favorite
            window.external.AddFavorite(bookmarkURL, bookmarkTitle);
        } else {
            // Other browsers (mainly WebKit - Chrome/Safari)
            alert('Please press ' + (/Mac/i.test(navigator.userAgent) ? 'CMD' : 'Strg') + ' + D to add this page to your favorites.');
        }

        return false;
    });

});

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
        modalClose();
    }
});

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

    $('.sw-js-modal-description').removeClass('sw-is-hidden');
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

    $('.sw-js-modal-mask').addClass('sw-is-hidden');
    $('.sw-js-modal').addClass('sw-is-hidden');

    $('.sw-js-saved-critical').text(0);
}

function modalOpen() {
    $('.sw-js-modal-mask').removeClass('sw-is-hidden');
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