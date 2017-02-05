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

function redirect($url) {
    ob_start();
    header('Location: /'.$url, true, 303);
    ob_end_flush();
    exit;
}

function postSkill($postData) {
    global $curl;

    $postArray = [];

    $personId = $postData['person_id'];

    foreach($postData as $key => $value) {
        if($key !== 'person_id') {
            $v = $value > 0
                ? $value
                : 0;

            $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $v];
        }
    }

    foreach($postArray as $post) {
        $result = $curl->post('person-attribute',$post);
    }
}

function postExpertise($postData) {
    global $curl;

    $postArray = [];

    $personId = $postData['person_id'];

    foreach($postData as $key => $value) {
        if($key !== 'person_id' && $value > 0) {
            $postArray[] = ['person_id' => $personId, 'expertise_id' => $key, 'level' => $value];
        }
    }

    foreach($postArray as $post) {
        $result = $curl->post('person-expertise',$post);
    }
}

function postSupernatural($postData) {
    global $curl;

    $postArray = [];

    $personId = $postData['person_id'];

    foreach($postData as $key => $value) {
        if($key !== 'person_id' && $value > 0) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $result = $curl->post('person-attribute',$post);
    }
}

function postWeapon($postData) {
    global $curl;

    $postArray = [];

    $personId = $postData['person_id'];

    foreach($postData as $key => $value) {
        if($key !== 'person_id') {
            $postArray[] = ['person_id' => $personId, 'weapon_id' => $key, 'weaponquality_id' => 3, 'equipped' => 0];
        }
    } // todo quality should not be hardcoded

    foreach($postArray as $post) {
        $result = $curl->post('person-weapon',$post);
    }
}

function postCalculation($postData, $hash) {
    global $curl;

    $person = $curl->get('person/hash/'.$hash)['data'][0];

    if(!$person['calculated']) {
        $postArray = [];

        $personId = $postData['person_id'];

        foreach($postData as $key => $value) {
            if($key !== 'person_id') {
                $v = $value > 0
                    ? $value
                    : 0;

                $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $v];
            }
        }

        foreach($postArray as $post) {
            $result = $curl->post('person-attribute',$post);
        }
    }
}

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
            break;

        case 'person--put':
            $result = $curl->put('person/hash/'.$POST_HASH,$postData);
            break;

        case 'person--characteristic':
            $result = $curl->post('person-characteristic',$postData);
            break;

        case 'person--milestone':
            $result = $curl->post('person-milestone',$postData);
            break;

        case 'person--skill':
            postSkill($postData);
            break;

        case 'person--expertise':
            postExpertise($postData);
            break;

        case 'person--supernatural':
            postSupernatural($postData);
            break;

        case 'person--weapon':
            postWeapon($postData);
            break;

        case 'person--calculation':
            postCalculation($postData, $POST_HASH);
            $curl->put('person/hash/'.$POST_HASH,['calculated' => 1]);
            break;
    }
}

$r = isset($POST_RETURN)
    ? $POST_RETURN
    : null;

$h = isset($POST_HASH)
    ? '&hash='.$POST_HASH
    : null;

echo '<a href="http://spelwerk.dev'.$r.$h.'">http://spelwerk.dev/'.$h.'</a>';

redirect($r.$h);