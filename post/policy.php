<?php
require_once('../php/config.php');

global $config_policy;

setcookie($config_policy, '1', time() + (9 * 365 * 24 * 60 * 60));

ob_start();
header('Location: '.$baseUrl.$_GET['return'], true, 303);
ob_end_flush();
exit;
?>