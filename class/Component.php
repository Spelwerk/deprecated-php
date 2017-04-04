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

    public function h1($title, $id = null) {
        echo(
            '<h1 id="'.$id.'">'.$title.'</h1>'
        );
    }

    public function h2($title, $id = null) {
        echo(
            '<h2 id="'.$id.'">'.$title.'</h2>'
        );
    }

    public function h3($title, $id = null) {
        echo(
            '<h3 id="'.$id.'">'.$title.'</h3>'
        );
    }

    public function h4($title, $id = null) {
        echo(
            '<h4 id="'.$id.'">'.$title.'</h4>'
        );
    }

    public function subtitle($content) {
        echo('<div class="sw-t-subtitle">'.$content.'</div>');
    }

    public function p($content) {
        echo('<p>'.$content.'</p>');
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

    // WRAP

    public function wrapStart() {
        echo('<section class="sw-l-wrap">');
    }

    public function wrapEnd() {
        echo('</section>');
    }

    // LINK

    public function link($href, $title) {
        echo(
            '<a class="sw-o-link" href="'.$href.'">'.$title.'</a>'
        );
    }

    public function linkButton($href, $title, $dangerous = false) {
        $dangerous = $dangerous
            ? ' sw-is-dangerous'
            : null;

        echo(
            '<a class="sw-o-button'.$dangerous.'" href="'.$href.'">'.
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
            '<div class="sw-js-list-chevron-up sw-c-list__action sw-is-hidden"><img src="/img/chevron-up.png"/></div>'.
            '<div class="sw-js-list-chevron-down sw-c-list__action"><img src="/img/chevron-down.png"/></div>'.
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
}