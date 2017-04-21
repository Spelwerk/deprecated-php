<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-21
 * Time: 14:21
 */
require_once('class/Curl.php');
require_once('php/config.php');
$curl = new Curl($config_curl);

$do = $_GET['d'];
$secret = $_GET['s'];

function user_set($route, $postData) {
    global $curl;

    $result = $curl->post($route,$postData);

    $token = isset($result['token'])
        ? $result['token']
        : null;

    user_unset();
    user_set_token($token);
}

function user_set_token($token) {
    global $cookieArray;

    $cookieName = $cookieArray['token'];

    setcookie($cookieName, $token, time() + (86400 * 30), "/");
}

function user_unset() {
    global $cookieArray;

    $cookieName = $cookieArray['token'];

    unset($_COOKIE[$cookieName]);

    setcookie($cookieName, '', time() - 3600, '/');

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}

function redirect($url) {
    ob_start();
    header('Location: '.$url, true, 303);
    ob_end_flush();
    exit;
}

switch($do)
{
    case 'login':
        $redirect = 'user/me';
        user_set('user/login/verify',['secret' => $secret]);
        break;

    case 'verify':
        $redirect = 'user/me';
        user_set('user/verify',['secret' => $secret]);
        break;

    default: break;
}

redirect($baseUrl.'/'.$redirect);