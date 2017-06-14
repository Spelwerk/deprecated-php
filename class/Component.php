<?php class Component {
    public function __construct() {}

    public function title($title) {
        echo(
            '<div class="sw-c-title">'.
            '<div class="sw-l-wrap sw-js-custom-title">'.$title.'</div>'.
            '</div>'.
            '<div id="content"></div>'
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

    public function roundImage($path) {
        echo('<div class="sw-c-roundimage"><img src="'.$path.'"/></div>');
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
            '<div class="sw-js-roll-title sw-c-roll__title">'.$title.'</div>'.
            '<div class="sw-c-roll__value">'.$value.'</div>'.
            '</div>'.
            '<div class="sw-js-roll-text sw-is-hidden">'.$description.'</div>'.
            '</button>'
        );
    }

    public function attribute($title, $value, $class = null) {
        echo(
            '<div class="sw-c-attribute">'.
            '<div class="sw-c-attribute__title'.$class.'">'.$title.'</div>'.
            '<div class="sw-c-attribute__value'.$class.'">'.$value.'</div>'.
            '</div>'
        );
    }

    // WRAP

    public function wrapStart($centered = false) {
        $center = $centered
            ? ' sw-u-center'
            : null;

        echo('<section class="sw-l-wrap'.$center.'">');
    }

    public function wrapEnd() {
        echo('</section>');
    }

    // SECTION

    public function sectionStart($class = null) {
        $class = isset($class)
            ? ' '.$class
            : null;

        echo('<section class="sw-l-section'.$class.'">');
    }

    public function sectionEnd() {
        echo('</section>');
    }

    // LINK

    public function link($href, $title) {
        echo(
            '<a class="sw-o-link" href="'.$href.'">'.$title.'</a>'
        );
    }

    public function linkButton($href, $title, $dangerous = false, $customClass = null) {
        $dangerous = $dangerous
            ? ' sw-is-dangerous'
            : null;

        $class = $customClass
            ? ' '.$customClass
            : null;

        echo(
            '<a class="sw-o-button'.$dangerous.$class.'" href="'.$href.'">'.
            '<div class="sw-o-button__title">'.$title.'</div>'.
            '</a>'
        );
    }

    public function linkAction($href, $title, $text, $icon = null, $dangerous = false, $customClass = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        $dangerous = $dangerous
            ? ' sw-is-dangerous'
            : null;

        $class = $customClass
            ? ' '.$customClass
            : null;

        echo(
            '<a class="sw-o-action'.$dangerous.$class.'" href="'.$href.'">'.
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
            '<div class="sw-js-list-chevron-up sw-c-list__action sw-is-hidden"><img src="/img/color/chevron-down.png"/></div>'.
            '<div class="sw-js-list-chevron-down sw-c-list__action"><img src="/img/color/chevron-right.png"/></div>'.
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

    public function listAction($title, $action = null, $options = null) {
        $icon = isset($options['icon'])
            ? $options['icon']
            : '/img/missing_icon.png';

        $class = isset($options['class'])
            ? $options['class']
            : null;

        echo(
            '<div class="sw-c-list'.$class.'">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '<div class="sw-c-list__action">'.
            $action.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    // RETURN

    public function returnButton($href) {
        echo('<div class="sw-l-quicklink">');

        $this->linkQuick($href,'Return','/img/return.png');

        echo('</div>');
    }
}