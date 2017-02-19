<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

//setcookie('sw_person_list', '', time() -2000);setcookie('sw_world_list', '', time() -2000);

require_once('php/config.php');

require_once('class/Curl.php');
require_once('class/Form.php');
require_once('class/Sitemap.php');
require_once('class/User.php');

$curl = new Curl($config_curl);
$form = new Form();

$user = isset($_COOKIE['sw_user_token'])
    ? new User($_COOKIE['sw_user_token'])
    : null;

$admin = isset($user)
    ? $user->isAdmin
    : 0;

$sitemap = new Sitemap($user);
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
    <script src="/js/menu.js"></script>

    <title>Spelwerk</title>
</head>
<body>

<?php
if(!isset($_COOKIE['sw_cookie_policy'])) {
    require_once('php/cookiepolicy.php');
}
?>

<div class="sw-l-header">
    <div class="sw-l-header__content">
        <div class="sw-l-header__hamburger sw-js-hamburger"><a href="#"><img src="/img/hamburger--white.png"/></a></div>
        <a class="sw-l-header__logo" href="/">spelwerk</a>
        <div class="sw-l-header__menu">
            <div class="sw-l-header__menu__content">
                <a class="sw-l-header__menu__item" href="/play">Play</a>
                <a class="sw-l-header__menu__item sw-js-menu">New</a>
                <a class="sw-l-header__menu__item sw-js-menu">View</a>
                <?php if(isset($user) && $user->isAdmin): ?>
                <a class="sw-l-header__menu__item" href="/admin">Admin</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sw-l-header__user sw-js-user"><a href="/user"><img src="/img/user--white.png"/></a></div>
    </div>
</div>

<div class="sw-l-submenu">
    <div class="sw-l-submenu__content sw-js-menu-new sw-is-hidden">
        <a class="sw-l-submenu__item" href="/play">Person</a>
        <a class="sw-l-submenu__item" href="/world">World</a>
    </div>
    <div class="sw-l-submenu__content sw-js-menu-view sw-is-hidden">
        <a class="sw-l-submenu__item" href="/view/person">Persons</a>
        <a class="sw-l-submenu__item" href="/view/world">Worlds</a>
    </div>
</div>

<div class="sw-l-content">
<?php
if(isset($sitemap->page)) {
    require_once($sitemap->page);
}
?>
</div>

<?php require_once('php/modal.php'); ?>

<div class="sw-l-mask--modal sw-js-modal-mask sw-is-hidden"></div>
<div class="sw-l-mask--menu sw-js-menu-mask sw-is-hidden"></div>
<div class="sw-js-saved-critical sw-is-hidden">0</div>
<div class="sw-js-roll-modifier sw-is-hidden">0</div>

</body>
</html>