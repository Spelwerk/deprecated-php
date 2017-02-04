<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-30
 * Time: 12:05
 */

require_once('class/Curl.php');
require_once('class/Form.php');

require_once('class/Admin.php');
require_once('class/System.php');
require_once('class/World.php');
require_once('class/Person.php');

$curl = new Curl([
    'url' => 'http://localhost',
    'port' => 3001,
    'apiKey' => '0732cc50dc8380e6f438a2ba1419d48985d70808'
]);

$form = new Form();
$admin = new Admin();
$system = new System();

require_once('site/play/new.php');
//require_once('site/admin/database.php');

?>