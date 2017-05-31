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

$curl = new Curl($config_curl);
$user = new User();

$POST_DATA = [];
$POST_ERROR = null;
$USER_TOKEN = $user->token;


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

$POST_SECRET = isset($_POST['post--secret'])
    ? $_POST['post--secret']
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

function cookie_add($type, $id, $secret = null) {
    global $cookieArray;

    $cookieName = null;

    foreach($cookieArray as $key => $value) {
        if($key == $type) {
            $cookieName = $value;
        }
    }

    if(isset($_COOKIE[$cookieName])) {
        $cookie = unserialize($_COOKIE[$cookieName]);
    }

    $cookie[] = isset($secret)
        ? ['id' => $id, 'secret'  => $secret]
        : ['id' => $id];

    setcookie($cookieName, serialize($cookie), time() + (9 * 365 * 24 * 60 * 60));
}


// USER

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

function user_save() {
    global $POST_ID, $POST_SECRET, $POST_CONTEXT, $USER_TOKEN, $curl, $user;

    $post = isset($POST_SECRET)
        ? ['insert_id' => $POST_ID, 'secret' => $POST_SECRET]
        : ['insert_id' => $POST_ID];

    $curl->post('user/id/'.$user->id.'/'.$POST_CONTEXT, $post, $USER_TOKEN);
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
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post, $USER_TOKEN);
    }
}

function table_has_delete() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = $key;
        }
    }

    foreach($postArray as $id) {
        $curl->delete($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2.'/'.$id, null, $USER_TOKEN);
    }
}

function table_has_value_post() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post, $USER_TOKEN);
    }
}

function table_has_value_put() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->put($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post, $USER_TOKEN);
    }
}

function table_secret_has_multiple_post() {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $POST_SECRET, 'insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

function table_secret_has_multiple_put() {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $POST_SECRET, 'insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $curl->put($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

function table_secret_has_multiple_value_post() {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['secret' => $POST_SECRET, 'insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

function table_secret_has_multiple_value_put() {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_CONTEXT2, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'insert_id') {
            $postArray[] = ['secret' => $POST_SECRET, 'insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->put($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $post);
    }
}

/** SWITCHES */

function switch_basic($do) {
    global $curl, $POST_ID, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do)
    {
        default: break;

        case 'basic--post':
            $result = $curl->post($POST_CONTEXT, $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--put':
            $curl->put($POST_CONTEXT.'/id/'.$POST_ID, $POST_DATA, $USER_TOKEN);
            break;

        case 'basic--delete':
            $curl->delete($POST_CONTEXT.'/id/'.$POST_ID, null, $USER_TOKEN);
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
            $curl->post($POST_CONTEXT.'/id/'.$POST_ID.'/'.$POST_CONTEXT2, $POST_DATA, $USER_TOKEN);
            break;
    }
}

function switch_person($do) {
    global $curl, $POST_ID, $POST_SECRET, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'person--post':
            $result = $curl->post('person',$POST_DATA,$USER_TOKEN);

            $POST_ID = $result['id'];
            $POST_SECRET = $result['secret'];

            cookie_add('person', $POST_ID, $POST_SECRET);
            break;

        case 'person--augmentation':
            table_secret_has_multiple_post();
            break;

        case 'person--background':
            $curl->put('person/id/'.$POST_ID.'/background',$POST_DATA);
            break;

        case 'person--bionic':
            table_secret_has_multiple_post();
            break;

        case 'person--bionic--custom': // todo
            break;

        case 'person--cheat':
            $curl->put('person/id/'.$POST_ID.'/cheat',$POST_DATA);
            break;

        case 'person--describe':
            $POST_DATA['calculated'] = 1;
            $curl->put('person/id/'.$POST_ID,$POST_DATA);
            break;

        case 'person--edit--description':
            $curl->put('person/id/'.$POST_ID,$POST_DATA);
            break;

        case 'person--attribute':
            table_secret_has_multiple_value_put();
            break;

        case 'person--attribute--money':
            table_secret_has_multiple_value_put();
            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_money' => 0]);
            break;

        case 'person--skill':
            table_secret_has_multiple_value_post();

            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_skill' => 0]);

            if(isset($_POST['post--experience'])) {
                $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--characteristic--gift':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/characteristic', $POST_DATA);
            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_gift' => $calc]);
            break;

        case 'person--characteristic--imperfection':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/characteristic', $POST_DATA);
            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_imperfection' => $calc]);
            break;

        case 'person--characteristic--delete':
            $curl->delete('person/id/'.$POST_ID.'/characteristic/'.$POST_CONTEXT, ['secret' => $POST_SECRET]);
            break;

        case 'person--expertise':
            table_secret_has_multiple_value_post();

            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_expertise' => 0]);

            if(isset($_POST['post--experience'])) {
                $curl->put('person/id/'.$POST_ID.'/attribute', ['secret' => $POST_SECRET, 'insert_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--expertise--custom': // todo
            break;

        case 'person--expertise--delete':
            $curl->delete('person/id/'.$POST_ID.'/expertise/'.$POST_CONTEXT, ['secret' => $POST_SECRET]);
            break;

        case 'person--focus':
            $curl->put('person/id/'.$POST_ID.'/focus', $POST_DATA);
            break;

        case 'person--gift': // todo
            break;

        case 'person--gift--custom': // todo
            break;

        case 'person--gift--delete': // todo
            break;

        case 'person--imperfection': // todo
            break;

        case 'person--imperfection--custom': // todo
            break;

        case 'person--imperfection--delete': // todo
            break;

        case 'person--identity':
            $curl->put('person/id/'.$POST_ID.'/identity', $POST_DATA);
            break;

        case 'person--manifestation':
            $curl->post('person/id/'.$POST_ID.'/manifestation', $POST_DATA);
            break;

        case 'person--doctrine':
            table_secret_has_multiple_value_post();

            if(isset($_POST['post--experience'])) {
                $curl->put('person/id/'.$POST_ID.'/attribute', ['secret' => $POST_SECRET, 'insert_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--manifestation--expertise':
            $fakeIdVar = 'insert_id__'.$POST_DATA['insert_id'];

            $POST_DATA = [$fakeIdVar => 1];

            table_secret_has_multiple_value_post();
            break;

        case 'person--manifestation--power':
            table_secret_has_multiple_value_put();
            $curl->put('person/id/'.$POST_ID, ['secret' => $POST_SECRET, 'point_power' => 0]);
            break;

        case 'person--milestone':
            $calc = intval($_POST['post--points']) - 1;
            $curl->post('person/id/'.$POST_ID.'/milestone',$POST_DATA);
            $curl->put('person/id/'.$POST_ID, ['secret' => $POST_SECRET, 'point_milestone' => $calc]);
            break;

        case 'person--milestone--custom': // todo
            break;

        case 'person--milestone--delete':
            $curl->delete('person/id/'.$POST_ID.'/milestone/'.$POST_CONTEXT, ['secret' => $POST_SECRET]);
            break;

        case 'person--nature':
            $curl->put('person/id/'.$POST_ID.'/nature', $POST_DATA);
            break;

        case 'person--protection':
            table_secret_has_multiple_post();
            break;

        case 'person--protection--custom': // todo
            break;

        case 'person--protection--equip':
            $curl->put('person/id/'.$POST_ID.'/protection/'.$POST_CONTEXT.'/equip/'.$POST_EXTRA, ['secret' => $POST_SECRET]);
            break;

        case 'person--protection--delete':
            $curl->delete('person/id/'.$POST_ID.'/protection/'.$POST_CONTEXT, ['secret' => $POST_SECRET]);
            break;

        case 'person--species':
            $curl->put('person/id/'.$POST_ID.'/species', $POST_DATA);
            break;

        case 'person--weapon':
            table_secret_has_multiple_post();
            break;

        case 'person--weapon--custom': // todo
            break;

        case 'person--weapon--equip':
            $curl->put('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT.'/equip/'.$POST_EXTRA, ['secret' => $POST_SECRET]);
            break;

        case 'person--weapon--delete':
            $curl->delete('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT, ['secret' => $POST_SECRET]);
            break;

        case 'person--wound':
            $curl->post('person/id/'.$POST_ID.'/'.$POST_CONTEXT, $POST_DATA);
            break;

        case 'person--wound--heal':
            $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2.'/heal/'.$POST_EXTRA, $POST_DATA);
            break;
    }
}

function switch_story($do) {
    global $curl, $POST_ID, $POST_SECRET, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'story--post':
            $result = $curl->post('story', $POST_DATA, $USER_TOKEN);

            $POST_ID = $result['id'];
            $POST_SECRET = $result['secret'];

            cookie_add('story', $POST_ID, $POST_SECRET);
            break;
    }
}

function switch_user($do) {
    global $curl, $user, $POST_ID, $POST_SECRET, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2, $USER_TOKEN;

    switch($do) {
        default: break;

        case 'user--new':
            user_set('user', $POST_DATA);
            break;

        case 'user--new--verify':
            user_set('user/verify', $POST_DATA);
            break;

        case 'user--new--timeout':
            $curl->post('user/verify/again', $POST_DATA);
            break;

        case 'user--login--password':
            user_set('user/login/password', $POST_DATA);
            break;

        case 'user--login--email':
            $curl->post('user/login/email', $POST_DATA);
            break;

        case 'user--login--verify':
            user_set('user/login/verify', $POST_DATA);
            break;

        case 'user--reset':
            $curl->post('user/reset/email', $POST_DATA);
            break;

        case 'user--reset--verify':
            user_set('user/reset/verify', $POST_DATA);
            break;

        case 'user--edit':
            $curl->put('user/id/'.$user->id, $POST_DATA, $USER_TOKEN);
            break;

        case 'user--admin':
            $curl->put('user/id/'.$user->id.'/admin', $POST_DATA, $USER_TOKEN);
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

    if(isset($POST_SECRET)) {
        $POST_DATA['secret'] = $POST_SECRET;
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

$h = isset($POST_SECRET)
    ? '/'.$POST_SECRET
    : null;

$a = isset($POST_RETURNAFTER)
    ? '/'.$POST_RETURNAFTER
    : null;

$d = isset($POST_RETURNID)
    ? '#'.$POST_RETURNID
    : '#content';

if(!$POST_ERROR) {
    //redirect($baseUrl.$r.$i.$h.$a.$d);
} else {
    print_r($POST_ERROR);
}

echo '<a href="'.$baseUrl.$r.$i.$h.$a.$d.'">'.$baseUrl.$r.$i.$h.$a.$d.'</a>';