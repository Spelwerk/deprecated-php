<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

require_once('php/config.php');

require_once('class/Component.php');
require_once('class/Curl.php');
require_once('class/Form.php');
require_once('class/Menu.php');
require_once('class/Sitemap.php');
require_once('class/User.php');

$component = new Component();
$curl = new Curl($config_curl);
$form = new Form();
$user = new User();

$menu = new Menu($user);
$sitemap = new Sitemap($user);

$menu->findActive($sitemap->menuID, $sitemap->menuLink);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" media="screen" href="/css/main.css"/>

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

</body>
</html>