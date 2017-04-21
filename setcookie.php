<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 21:23
 */
require_once('php/config.php');

global $cookieArray;

setcookie($cookieArray['policy'], '1', time() + (9 * 365 * 24 * 60 * 60));

ob_start();
header('Location: '.$baseUrl.$_GET['return'], true, 303);
ob_end_flush();
exit;
?>