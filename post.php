<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 03/02/2017
 * Time: 11:23
 */

require_once('php/post_default.php');

require_once('php/post_manifestation.php');
require_once('php/post_person.php');
require_once('php/post_user.php');
require_once('php/post_world.php');

if(isset($POST_DO) && isset($POST_RETURN)) {
    $POST_DATA = [];

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

        case 'manifestation':
            switch_manifestation($POST_DO);
            break;

        case 'person':
            switch_person($POST_DO);
            break;

        case 'user':
            switch_user($POST_DO);
            break;

        case 'world':
            switch_world($POST_DO);
            break;
    }
}

$r = isset($POST_RETURN)
    ? $POST_RETURN
    : null;

$i = isset($POST_ID)
    ? '/'.$POST_ID
    : null;

$h = isset($POST_HASH)
    ? '/'.$POST_HASH
    : null;

$d = isset($POST_RETURNID)
    ? '#'.$POST_RETURNID
    : null;

$a = isset($POST_RETURNAFTER)
    ? '/'.$POST_RETURNAFTER
    : null;

if(!$POST_ERROR) {
    redirect($baseUrl.$r.$i.$h.$a.$d);
} else {
    print_r($POST_ERROR);
}

echo '<a href="'.$baseUrl.$r.$i.$h.$a.$d.'">'.$baseUrl.$r.$i.$h.$a.$d.'</a>';