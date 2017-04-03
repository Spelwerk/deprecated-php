<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 02/04/2017
 * Time: 09:22
 */
class Component {
    public function __construct() {}

    public function title($title) {
        echo(
            '<div class="sw-c-title">'.
            '<div class="sw-l-wrap">'.$title.'</div>'.
            '</div>'
        );
    }

    public function roll($title, $description, $icon = null, $value = null, $data = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        $value = isset($value)
            ? $value
            : null;

        $data = isset($data)
            ? ' '.$data
            : null;

        echo(
            '<button class="sw-js-roll sw-c-roll"'.$data.'>'.
            '<div class="sw-c-roll__container">'.
            '<div class="sw-c-roll__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-roll__title">'.$title.'</div>'.
            '<div class="sw-c-roll__value">'.$value.'</div>'.
            '</div>'.
            '<div class="sw-js-roll-text sw-is-hidden">'.$description.'</div>'.
            '</button>'
        );
    }

    public function attribute($title, $value) {
        echo(
            '<div class="sw-c-attribute">'.
            '<div class="sw-c-attribute__title">'.$title.'</div>'.
            '<div class="sw-c-attribute__value">'.$value.'</div>'.
            '</div>'
        );
    }

    // LINK

    public function link($href, $title) {
        echo(
            '<a class="sw-o-link" href="'.$href.'">'.$title.'</a>'
        );
    }

    public function linkButton($href, $title, $icon = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<a class="sw-o-button" href="'.$href.'">'.
            '<div class="sw-o-button__image"><img src="'.$icon.'"/></div>'.
            '<div class="sw-o-button__title">'.$title.'</div>'.
            '</a>'
        );
    }

    public function linkAction($href, $title, $text, $icon = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<a class="sw-o-action" href="'.$href.'">'.
            '<div class="sw-o-action__image"><img src="'.$icon.'"/></div>'.
            '<div class="sw-o-action__container">'.
            '<div class="sw-o-action__title">'.$title.'</div>'.
            '<div class="sw-o-action__text">'.$text.'</div>'.
            '</div>'.
            '</a>'
        );
    }

    public function linkQuick($href, $title, $icon) {
        echo(
            '<a class="sw-c-quicklink" href="'.$href.'" title="'.$title.'"><img src="'.$icon.'"/></a>'
        );
    }

    // LIST

    public function listItem($title, $description, $icon = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<div class="sw-js-list sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-list-head sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '</div>'.
            '<div class="sw-js-list-body sw-c-list__body sw-is-hidden">'.
            '<div class="sw-c-list__text">'.
            $description.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    public function listEdit($title, $description, $icon = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<div class="sw-js-list sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-list-head sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '<div class="sw-c-list__action"><img src="/img/remove.png"/></div>'.
            '<div class="sw-c-list__action"><img src="/img/edit.png"/></div>'.
            '</div>'.
            '<div class="sw-js-list-body sw-c-list__body">'.
            '<div class="sw-c-list__text">'.
            $description.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        ); // todo add input textfield
    }

    public function listCheckbox($title, $description) {
        echo(
            '<div class="sw-js-list sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-list-head sw-c-list__head">'.
            '<div class="sw-js-checkbox-true sw-c-list__select sw-is-hidden"><img src="/img/checkbox-true.png"/></div>'.
            '<div class="sw-js-checkbox-false sw-c-list__select"><img src="/img/checkbox-false.png"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '</div>'.
            '<div class="sw-js-list-body sw-c-list__body sw-is-hidden">'.
            '<div class="sw-c-list__text">'.
            $description.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    public function listRadio($title, $description) {
        echo(
            '<div class="sw-js-list sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-list-head sw-c-list__head">'.
            '<div class="sw-js-radio-true sw-c-list__select sw-is-hidden"><img src="/img/radio-true.png"/></div>'.
            '<div class="sw-js-radio-false sw-c-list__select"><img src="/img/radio-false.png"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '</div>'.
            '<div class="sw-js-list-body sw-c-list__body sw-is-hidden">'.
            '<div class="sw-c-list__text">'.
            $description.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    // RANDOM

    public function randomRadio($title) {
        echo(
            '<div class="sw-js-randomizer sw-c-randomizer">'.
            '<button type="button" class="sw-js-random-radio sw-c-randomizer__button">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-js-random-title sw-c-randomizer__title">&nbsp;</div>'.
            '<div class="sw-js-random-info sw-c-randomizer__info">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$title.'</div>'.
            '</div>'
        );
    }

    public function randomNumber($title, $times) {
        echo(
            '<div class="sw-js-randomizer sw-c-randomizer">'.
            '<button type="button" class="sw-js-random-number sw-c-randomizer__button" data-roll-type="'.$title.'" data-rolls="'.$times.'">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-js-random-value sw-c-randomizer__value">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$title.'</div>'.
            '</div>'
        );
    }
}

/*

*/