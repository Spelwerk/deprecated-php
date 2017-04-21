<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 09:24
 */
require_once('php/config.php');

global $cookieArray;

foreach($cookieArray as $key => $value) {
    setcookie($value, '', time() -2000);
}

ob_start();
header('Location: '.$baseUrl.$_GET['return'], true, 303);
ob_end_flush();
exit;
?>