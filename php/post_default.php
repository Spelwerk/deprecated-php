<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 19/02/2017
 * Time: 09:03
 */

require_once('config.php');
require_once('./class/Curl.php');

$curl = new Curl($config_curl);

$POST_ERROR = null;

$POST_DO = isset($_POST['post--do'])
    ? $_POST['post--do']
    : null;

$POST_RETURN = isset($_POST['post--return'])
    ? $_POST['post--return']
    : null;

$POST_RETURNID = isset($_POST['post--returnid'])
    ? $_POST['post--returnid']
    : null;

$POST_RETURNAFTER = isset($_POST['post--returnafter'])
    ? $_POST['post--returnafter']
    : null;

$POST_ID = isset($_POST['post--id'])
    ? $_POST['post--id']
    : null;

$POST_HASH = isset($_POST['post--hash'])
    ? $_POST['post--hash']
    : null;

$POST_USER = isset($_POST['post--user'])
    ? $_POST['post--user']
    : null;

$USER_TOKEN = null;

function redirect($url) {
    ob_start();
    header('Location: '.$url, true, 303);
    ob_end_flush();
    exit;
}

function checkError($resultArray) {
    global $POST_ERROR;

    if($resultArray) {
        foreach($resultArray as $key => $res) {
            if(isset($res['error'])) {
                $POST_ERROR[] = $res['error'];
            }
        }
    }
}
