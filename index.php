<?php
require_once('php/config.php');

require_once('class/Component.php');
require_once('class/Curl.php');
require_once('class/Form.php');
require_once('class/Menu.php');
require_once('class/Sitemap.php');
require_once('class/User.php');
require_once('class/System.php');

global $config_curl, $cookieArray;

$component = new Component();
$curl = new Curl($config_curl, $cookieArray['token']);
$form = new Form();
$user = new User();
$system = new System();

$menu = new Menu($user);
$sitemap = new Sitemap($user);

echo($sitemap->command0.'/');
echo($sitemap->command1.'/');
echo($sitemap->command2.'/');
echo($sitemap->command3.'/');
echo($sitemap->command4.'/');
echo($sitemap->command5.'/');
echo(' = '.$sitemap->page);

$menu->findActive($sitemap->menuID, $sitemap->menuLink);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" media="screen" href="/css/v3/main.css"/>

    <script src="/dependency/prefixfree.min.js"></script>
    <script src="/dependency/jquery-3.2.0.min.js"></script>

    <script src="/js/menu.js"></script>

    <title>Spelwerk</title>
</head>
<body>

<?php
if(!isset($_COOKIE[$cookieArray['policy']])) {
    require_once('php/cookiepolicy.php');
}
?>

<header class="sw-c-header">
    <div class="sw-l-wrap">
        <div class="sw-c-header__top">
            <div class="sw-c-header__logo">spelwerk</div>
            <div class="sw-c-header__tabs">
                <?php $menu->buildTab(); ?>
            </div>
        </div>
    </div>
    <div class="sw-c-header__bottom">
        <div class="sw-l-wrap">
            <?php $menu->buildList(); ?>
        </div>
    </div>
</header>

<div class="sw-l-content">
    <?php
    if($maintenanceMode) {
        require('page/error/maintenance_mode.php');
    } else {
        if(isset($sitemap->page)) {
            require_once($sitemap->page);
        }
    }
    ?>
</div>

<footer class="sw-l-footer">
    <div class="sw-l-wrap">

    </div>
</footer>

<div class="sw-js-modal sw-c-modal sw-is-hidden">
    <div class="sw-js-modal-title sw-c-modal__title">Title</div>
    <div class="sw-c-modal__content">
        <div class="sw-c-modal__body">
            <div class="sw-js-modal-with sw-c-modal__body__with sw-is-hidden"></div>
            <div class="sw-js-modal-result sw-c-modal__body__result sw-is-hidden"></div>
            <div class="sw-js-modal-critical sw-c-modal__body__critical sw-is-hidden">Press the dice to roll</div>
            <div class="sw-js-modal-count sw-c-modal__body__count sw-is-hidden"></div>
            <div class="sw-js-modal-description sw-c-modal__body__description sw-is-hidden"></div>
        </div>
        <div class="sw-c-modal__button">
            <div class="sw-js-modal-info sw-c-modal__button__item"><img src="/img/modal/info.png"/></div>
            <div class="sw-js-modal-close sw-c-modal__button__item"><img src="/img/modal/close.png"/></div>
            <div class="sw-js-modal-roll sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/dice.png"/></div>
            <div class="sw-js-modal-consumable sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/dice.png"/></div>
            <div class="sw-js-modal-supernatural sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/magic.png"/></div>
            <div class="sw-js-modal-weapon sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/damage.png"/></div>
        </div>
    </div>
</div>

<div class="sw-js-modal-mask sw-u-mask sw-is-hidden"></div>
<div class="sw-js-saved-critical sw-is-hidden">0</div>
<div class="sw-js-roll-modifier sw-is-hidden">0</div>

<script src="/js/validation.js"></script>
<script src="/js/play.js"></script>

</body>
</html>