<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

require_once('php/config.php');

require_once('class/Admin.php');
require_once('class/Curl.php');
require_once('class/SiteError.php');
require_once('class/Form.php');
require_once('class/Person.php');
require_once('class/Sitemap.php');

require_once('class/System.php');
require_once('class/User.php');
require_once('class/World.php');

$sitemap = new Sitemap();
$curl = new Curl($config_curl);
$form = new Form();
$error = new SiteError($sitemap->id);

$user = isset($_COOKIE['sw_user_token'])
    ? new User($_COOKIE['sw_user_token'])
    : null;

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

    <title>Spelwerk</title>
</head>
<body>

<div class="sw-l-header">
    <div class="sw-l-header__content">
        <div class="sw-l-header__hamburger sw-js-hamburger"><a href="#"><img src="/img/hamburger--white.png"/></a></div>
        <a class="sw-l-header__logo" href="/">spelwerk</a>
        <div class="sw-l-header__menu">
            <div class="sw-l-header__menu__content">
                <?php /*<a class="sw-l-header__menu__item sw-js-menu" href="/world">World</a>*/ ?>
                <a class="sw-l-header__menu__item sw-js-menu">Play</a>
                <a class="sw-l-header__menu__item sw-js-menu">View</a>
            </div>
        </div>
        <div class="sw-l-header__user sw-js-user"><a href="/user"><img src="/img/user--white.png"/></a></div>
    </div>
</div>

<div class="sw-l-submenu">
    <div class="sw-l-submenu__content sw-js-menu-play sw-is-hidden">
        <a class="sw-l-submenu__item" href="/play">Create</a>
        <a class="sw-l-submenu__item" href="/view/person">Saved</a>
    </div>
    <div class="sw-l-submenu__content sw-js-menu-view sw-is-hidden">
        <a class="sw-l-submenu__item" href="/view/person">Person</a>
    </div>
</div>

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

<div class="sw-l-mask--modal sw-js-modal-mask sw-is-hidden"></div>
<div class="sw-l-mask--menu sw-js-menu-mask sw-is-hidden"></div>
<div class="sw-js-saved-critical sw-is-hidden">0</div>
<div class="sw-js-roll-modifier sw-is-hidden">0</div>

</body>
</html>