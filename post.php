<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 03/02/2017
 * Time: 11:23
 */

require_once('class/Curl.php');
require_once('class/User.php');
require_once('php/config.php');

global $config_curl, $cookieArray;

$curl = new Curl($config_curl, $cookieArray['token']);

$POST_DATA = [];
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

$POST_CONTEXT = isset($_POST['post--context'])
    ? $_POST['post--context']
    : null;

$POST_CONTEXT2 = isset($_POST['post--context2'])
    ? $_POST['post--context2']
    : null;

$POST_EXTRA = isset($_POST['post--extra'])
    ? $_POST['post--extra']
    : null;

$POST_EXTRA2 = isset($_POST['post--extra2'])
    ? $_POST['post--extra2']
    : null;

function redirect($url) {
    ob_start();
    header('Location: '.$url, true, 303);
    ob_end_flush();
    exit;
}

// USER

function user_set($route) {
    global $curl, $cookieArray, $POST_DATA, $POST_ID;

    $result = $curl->post($route, $POST_DATA);

    $token = isset($result['token'])
        ? $result['token']
        : null;

    $POST_ID = isset($result['id'])
        ? $result['id']
        : null;

    user_unset();

    $cookieName = $cookieArray['token'];

    setcookie($cookieName, $token, time() + (86400 * 30), "/");
}

function user_save() {
    global $POST_ID, $POST_CONTEXT, $curl;

    $curl->post('user/id/'.$POST_ID.'/'.$POST_CONTEXT, ['insert_id' => $POST_ID]);
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

// TABLE

function table_has_post() {
    global $POST_DATA, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

function table_has_delete() {
    global $POST_DATA, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = $key;
        }
    }

    foreach($postArray as $id) {
        $curl->delete($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2.'/'.$id, null);
    }
}

function table_has_value_post() {
    global $POST_DATA, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

function table_has_value_put() {
    global $POST_DATA, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->put($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}


/** SWITCHES */

function switch_basic($do) {
    global $curl, $POST_ID, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do)
    {
        default: break;

        case 'basic--post':
            $result = $curl->post($POST_CONTEXT, $POST_DATA);
            $POST_ID = $result['id'];
            break;

        case 'basic--put':
            $curl->put($POST_CONTEXT.'/id/'.$POST_ID, $POST_DATA);
            break;

        case 'basic--delete':
            $curl->delete($POST_CONTEXT.'/id/'.$POST_ID, null);
            break;

        case 'basic--has--post':
            table_has_post();
            break;

        case 'basic--has--put':
            table_has_post();
            break;

        case 'basic--has--delete':
            table_has_delete();
            break;

        case 'basic--has--multiple--value--post':
            table_has_value_post();
            break;

        case 'basic--has--multiple--value--put':
            table_has_value_put();
            break;

        case 'basic--has--value':
            $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $POST_DATA);
            break;
    }
}

function switch_person($do) {
    global $curl, $POST_ID, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        // POST

        case 'person--post':
            $result = $curl->post('person', $POST_DATA);
            $POST_ID = $result['id'];
            break;

        case 'person--post--doctrine--expertise':
            $fakeIdVar = 'insert_id__'.$POST_DATA['insert_id'];

            $POST_DATA = [$fakeIdVar => 1];

            table_has_value_post();
            $curl->put('person/id/'.$POST_ID, ['point_doctrine_expertise' => 0]);
            break;

        case 'person--post--power':
            table_has_value_put();
            $curl->put('person/id/'.$POST_ID, ['point_power' => 0]);
            break;

        case 'person--post--money':
            table_has_value_put();
            $curl->put('person/id/'.$POST_ID, ['point_money' => 0]);
            break;

        case 'person--post--gift':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/gift', $POST_DATA);
            $curl->put('person/id/'.$POST_ID, ['point_gift' => $calc]);
            break;

        case 'person--post--imperfection':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/imperfection', $POST_DATA);
            $curl->put('person/id/'.$POST_ID, ['point_imperfection' => $calc]);
            break;

        case 'person--post--milestone':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/milestone', $POST_DATA);
            $curl->put('person/id/'.$POST_ID, ['point_milestone' => $calc]);
            break;

        case 'person--post--skill':
            table_has_value_post();
            $curl->put('person/id/'.$POST_ID, ['point_skill' => 0]);
            break;

        case 'person--post--expertise':
            table_has_value_post();
            $curl->put('person/id/'.$POST_ID, ['point_expertise' => 0]);
            break;

        case 'person--post--doctrine':
            table_has_value_post();
            $curl->put('person/id/'.$POST_ID, ['point_doctrine' => 0]);
            break;

        case 'person--post--description':
            $POST_DATA['calculated'] = 1;
            $curl->put('person/id/'.$POST_ID, $POST_DATA);
            break;

        // CONTEXTUAL

        case 'person--put':
            $curl->put('person/id/'.$POST_ID, $POST_DATA);
            break;

        case 'person--put--context':
            $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT, $POST_DATA);
            break;

        case 'person--delete--context':
            $curl->delete('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2);
            break;

        case 'person--has--post':
            table_has_post();
            break;

        case 'person--has--delete':
            table_has_delete();
            break;

        case 'person--experience--post':
            table_has_value_post();

            if(isset($_POST['post--experience'])) {
                $curl->put('person/id/'.$POST_ID.'/attribute', ['attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--has--value--post':
            table_has_value_put();
            break;

        case 'person--has--value--put':
            table_has_value_put();
            break;

        case 'person--equip':
            $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2.'/equip/'.$POST_EXTRA);
            break;

        // SPECIFIC

        case 'person--cheat':
            $curl->put('person/id/'.$POST_ID.'/cheat', $POST_DATA);
            break;

        case 'person--attribute':
            table_has_value_put();
            break;

        case 'person--wound':
            $curl->post('person/id/'.$POST_ID.'/'.$POST_CONTEXT, $POST_DATA);
            break;

        case 'person--wound--heal':
            $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2.'/heal/'.$POST_EXTRA, $POST_DATA);
            break;
    }
}

function switch_user($do) {
    global $curl, $POST_ID, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'user--post':
            user_set('user');
            break;

        case 'user--post--verify':
            $curl->post('user/verify/verify', $POST_DATA);
            break;

        case 'user--post--timeout':
            $curl->post('user/verify/email', $POST_DATA);
            break;

        case 'user--login':
            user_set('user/login/password');
            break;

        case 'user--login--email':
            $curl->post('user/login/email', $POST_DATA);
            break;

        case 'user--login--verify':
            user_set('user/login/verify');
            break;

        case 'user--password':
            $curl->post('user/reset/email', $POST_DATA);
            break;

        case 'user--password--verify':
            $curl->post('user/reset/verify', $POST_DATA);
            break;

        case 'user--edit':
            $curl->put('user/id/'.$POST_ID, $POST_DATA);
            break;

        case 'user--admin':
            $curl->put('user/id/'.$POST_ID.'/admin', $POST_DATA);
            break;

        case 'user--logout':
            user_unset();
            break;

        case 'user--save':
            user_save();
            break;
    }
}

/** MAIN SWITCH */

if(isset($POST_DO) && isset($POST_RETURN)) {
    unset($_POST['x']);
    unset($_POST['y']);

    foreach($_POST as $key => $value) {
        $explode = explode('--', $key);

        if($explode[0] != 'post') {
            $POST_DATA[$explode[1]] = $value;
        }
    }

    $topSwitch = explode('--', $POST_DO)[0];

    switch($topSwitch)
    {
        default: break;

        case 'basic':
            switch_basic($POST_DO);
            break;

        case 'person':
            switch_person($POST_DO);
            break;

        case 'story':
            switch_story($POST_DO);
            break;

        case 'user':
            switch_user($POST_DO);
            break;
    }
}

/** END */

$r = isset($POST_RETURN)
    ? '/'.$POST_RETURN
    : null;

$i = isset($POST_ID)
    ? '/'.$POST_ID
    : null;

$a = isset($POST_RETURNAFTER)
    ? '/'.$POST_RETURNAFTER
    : null;

$d = isset($POST_RETURNID)
    ? '#'.$POST_RETURNID
    : null;

if(!$POST_ERROR) {
    redirect($baseUrl.$r.$i.$a.$d);
} else {
    print_r($POST_ERROR);
}

echo '<a href="'.$baseUrl.$r.$i.$a.$d.'">'.$baseUrl.$r.$i.$a.$d.'</a>';