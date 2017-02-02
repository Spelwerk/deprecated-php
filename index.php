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
    'apiKey' => ''
]);

$form = new Form();
$admin = new Admin();
$system = new System();

//require_once('site/play/new.php');
require_once('site/admin/database.php');

?>