<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

require_once('class/Sitemap.php');
require_once('class/Curl.php');
require_once('class/Form.php');

require_once('class/Admin.php');
require_once('class/System.php');
require_once('class/World.php');
require_once('class/Person.php');

$sitemap = new Sitemap();
$curl = new Curl([
    'url' => 'http://localhost',
    'port' => 3001,
    'apiKey' => '0732cc50dc8380e6f438a2ba1419d48985d70808'
]);

$form = new Form();

$sitemap->buildMap();

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" media="screen" href="/dependency/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css">

    <script src="/dependency/prefixfree.min.js"></script>
    <script src="/dependency/jquery-2.2.4.min.js"></script>
    <!--
    <script src="js/list.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/view.js"></script>
    <script src="js/wizard.js"></script>
    -->
    <title>Spelwerk</title>
</head>
<body>

<?php
if(isset($sitemap->page)) {
    require_once($sitemap->page);
}
?>

</body>
</html>