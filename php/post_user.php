<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 19/02/2017
 * Time: 09:04
 */

function unsetUser() {
    unset($_COOKIE['sw_user_token']);

    setcookie('sw_user_token', '', time() - 3600, '/');

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}

function setUser($token) {
    setcookie('sw_user_token', $token, time() + (86400 * 30), "/");
}


function user_postUser($postData) {
    global $curl;

    $resultArray = null;

    if($postData['password'] == $postData['password2']) {
        $resultArray[] = $curl->post('user', $postData);
    }

    checkError($resultArray);
}

function user_verifyUser($postData) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->post('user/verify', $postData);

    checkError($resultArray);
}

function user_resendVerification($postData) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->post('user/verify/again', $postData);

    checkError($resultArray);
}

function user_loginPass($postData) {
    global $curl;

    unsetUser();

    if($postData['username'] && $postData['password']) {
        $result = $curl->post('user/login/password', $postData);
    }

    $token = isset($result['token'])
        ? $result['token']
        : null;

    setUser($token);
}

function user_loginMail($postData) {
    global $curl;

    $resultArray[] = null;

    if($postData['email']) {
        $resultArray[] = $curl->post('user/login/mail/start', $postData);
    }

    checkError($resultArray);
}

function user_loginMailVerify($postData) {
    global $curl;

    unsetUser();

    if($postData['verification']) {
        $result = $curl->post('user/login/mail/verify', $postData);
    }

    $token = isset($result['token'])
        ? $result['token']
        : null;

    setUser($token);
}

function user_passMail($postData) {
    global $curl;

    $resultArray = null;

    if($postData['email']) {
        $resultArray[] = $curl->put('user/password/start', $postData);
    }

    checkError($resultArray);
}

function user_passVerify($postData) {
    global $curl;

    $resultArray = null;

    if($postData['verification'] && $postData['password']) {
        $resultArray[] = $curl->put('user/password/set', $postData);
    }

    checkError($resultArray);
}

function user_savePerson($userId, $personId, $personHash) {
    global $curl;

    $resultArray = null;

    $post = isset($personHash)
        ? ['user_id' => $userId, 'person_id' => $personId, 'hash' => $personHash]
        : ['user_id' => $userId, 'person_id' => $personId];

    $resultArray[] = $curl->post('user-person', $post);

    checkError($resultArray);
}

function user_saveWorld($userId, $worldId, $worldHash) {
    global $curl;

    $resultArray = null;

    $post = isset($worldHash)
        ? ['user_id' => $userId, 'world_id' => $worldId, 'hash' => $worldHash]
        : ['user_id' => $userId, 'world_id' => $worldId];

    $resultArray[] = $curl->post('user-world', $post);

    checkError($resultArray);
}


function switch_user($do) {
    global $POST_DATA, $POST_ID, $POST_HASH, $POST_USER;

    switch($do) {
        default: break;

        case 'user--new':
            user_postUser($POST_DATA);
            break;

        case 'user--new--verify':
            user_verifyUser($POST_DATA);
            break;

        case 'user--new--timeout':
            user_resendVerification($POST_DATA);
            break;

        case 'user--login--pass':
            user_loginPass($POST_DATA);
            break;

        case 'user--login--mail':
            user_loginMail($POST_DATA);
            break;

        case 'user--login--verify':
            user_loginMailVerify($POST_DATA);
            break;

        case 'user--reset':
            user_passMail($POST_DATA);
            break;

        case 'user--password':
            user_passVerify($POST_DATA);
            break;

        case 'user--logout':
            unsetUser();
            break;

        case 'user--save':
            user_savePerson($POST_USER, $POST_ID, $POST_HASH);
            break;
    }
}