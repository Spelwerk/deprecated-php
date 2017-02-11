<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

require_once('php/config.php');

require_once('class/Sitemap.php');
require_once('class/Curl.php');
require_once('class/Form.php');

require_once('class/Admin.php');
require_once('class/System.php');
require_once('class/World.php');
require_once('class/Person.php');

$sitemap = new Sitemap();

$curl = new Curl($config_curl);

$form = new Form();

$sitemap->buildMap();

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" media="screen" href="/dependency/reset.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css"/>

    <script src="/dependency/prefixfree.min.js"></script>
    <script src="/dependency/jquery-2.2.4.min.js"></script>

    <script src="/js/main.js"></script>
    <!--
    <script src="js/list.js"></script>
    <script src="js/view.js"></script>
    <script src="js/wizard.js"></script>
    -->
    <title>Spelwerk</title>
</head>
<body>

<div class="sw-l-content">
    <?php
    if(isset($sitemap->page)) {
        require_once($sitemap->page);
    }
    ?>
</div>

<div class="sw-c-modal sw-js-modal sw-is-hidden">
    <div class="sw-c-modal__title sw-js-modal-title">Title</div>
    <div class="sw-c-modal__content">
        <div class="sw-c-modal__body">
            <div class="sw-c-modal__body__with sw-js-modal-with sw-is-hidden"></div>
            <div class="sw-c-modal__body__result sw-js-modal-result sw-is-hidden"></div>
            <div class="sw-c-modal__body__critical sw-js-modal-critical sw-is-hidden">Press the dice to roll</div>
            <div class="sw-c-modal__body__count sw-js-modal-count sw-is-hidden"></div>
            <div class="sw-c-modal__body__description sw-js-modal-description sw-is-hidden"></div>
        </div>
        <div class="sw-c-modal__button">
            <div class="sw-c-modal__button__item sw-js-modal-info"><img src="/img/modal/info.png"/></div>
            <div class="sw-c-modal__button__item sw-js-modal-close"><img src="/img/modal/close.png"/></div>
            <div class="sw-c-modal__button__item sw-js-modal-roll sw-is-hidden"><img src="/img/modal/dice.png"/></div>
            <div class="sw-c-modal__button__item sw-js-modal-consumable sw-is-hidden"><img src="/img/modal/dice.png"/></div>
            <div class="sw-c-modal__button__item sw-js-modal-supernatural sw-is-hidden"><img src="/img/modal/magic.png"/></div>
            <div class="sw-c-modal__button__item sw-js-modal-weapon sw-is-hidden"><img src="/img/modal/damage.png"/></div>
        </div>
    </div>
</div>

<div class="sw-l-mask sw-js-mask sw-is-hidden"></div>
<div class="sw-js-saved-critical sw-is-hidden">0</div>
<div class="sw-js-roll-modifier sw-is-hidden">0</div>

</body>
</html>