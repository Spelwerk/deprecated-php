<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 03/02/2017
 * Time: 11:23
 */

require_once('class/Curl.php');

$curl = new Curl([
    'url' => 'http://localhost',
    'port' => 3001,
    'apiKey' => '0732cc50dc8380e6f438a2ba1419d48985d70808'
]);

$POST_DO = isset($_POST['post--do'])
    ? $_POST['post--do']
    : null;

$POST_RETURN = isset($_POST['post--return'])
    ? $_POST['post--return']
    : null;

$POST_HASH = isset($_POST['post--hash'])
    ? $_POST['post--hash']
    : null;

if(isset($POST_DO) && isset($POST_RETURN)) {

    $postData = [];

    foreach($_POST as $key => $value) {
        if($key !== 'post--do' && $key !== 'post--return' && $key !== 'post--hash') {
            $explode = explode('--', $key);

            $postData[$explode[1]] = $value;
        }
    }

    switch($POST_DO)
    {
        default: break;

        case 'person--post':
            $result = $curl->post('person',$postData);
            $POST_HASH = $result['hash'];
            print_r($result);
            break;

        case 'person--put':
            $result = $curl->put('person/hash/'.$POST_HASH,$postData);
            print_r($result);
            break;

        case 'person--characteristic':
            $result = $curl->post('person-characteristic',$postData);
            print_r($result);
            break;

        case 'person--milestone':
            $result = $curl->post('person-milestone',$postData);
            print_r($result);
            break;
    }


}

$r = isset($POST_RETURN)
    ? $POST_RETURN
    : null;

$h = isset($POST_HASH)
    ? '?hash='.$POST_HASH
    : null;

//redirect($r.$h);

echo '<a href="http://spelwerk.dev'.$r.$h.'">http://spelwerk.dev/'.$h.'</a>';

function redirect($url) {
    ob_start();
    header('Location: /'.$url, true, 303);
    ob_end_flush();
    exit;
}