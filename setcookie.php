<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 21:23
 */

setcookie('sw_cookie_policy', '1', time() + (9 * 365 * 24 * 60 * 60));

ob_start();
header('Location: https://spelwerk.com/', true, 303);
ob_end_flush();
exit;
?>