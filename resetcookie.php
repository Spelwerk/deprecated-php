<?php require_once('php/config.php');

global $config_policy, $config_token;

setcookie($config_policy, '', time() -2000);
setcookie($config_token, '', time() -2000);

ob_start();
header('Location: '.$baseUrl.$_GET['return'], true, 303);
ob_end_flush();
exit;
?>