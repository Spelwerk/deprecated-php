<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 03/02/2017
 * Time: 11:23
 */

require_once('php/config.php');
require_once('class/Curl.php');

$curl = new Curl($config_curl);

$POST_DO = isset($_POST['post--do'])
    ? $_POST['post--do']
    : null;

$POST_RETURN = isset($_POST['post--return'])
    ? $_POST['post--return']
    : null;

$POST_ID = isset($_POST['post--id'])
    ? $_POST['post--id']
    : null;

$POST_HASH = isset($_POST['post--hash'])
    ? $_POST['post--hash']
    : null;

$USER_TOKEN = null;

function redirect($url) {
    ob_start();
    header('Location: http://spelwerk.dev/'.$url, true, 303);
    ob_end_flush();
    exit;
}

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


function person_postPerson($postData) {
    global $curl;

    $age = intval($postData['age']);

    $world = $curl->get('world/id/'.$postData['world_id'])['data'][0];
    $species = $curl->get('species/id/'.$postData['species_id'])['data'][0];

    $split_supernatural = floor($age / $world['split_supernatural']);
    $split_milestone = floor($age / $world['split_milestone']);
    $split_skill = floor($age / $world['split_skill']) * intval($species['multiply_skill']);
    $split_expertise = floor($age / $world['split_expertise']) * intval($species['multiply_expertise']);
    $split_relationship = floor($age / $world['split_relationship']);

    $point_supernatural = $split_supernatural < $world['max_supernatural']
        ? $split_supernatural
        : $world['max_supernatural'];

    $point_money = $split_milestone < $world['max_milestone_flexible']
        ? $split_milestone
        : $world['max_milestone_flexible'];

    $point_milestone_upbringing = $split_milestone < $world['max_milestone_upbringing']
        ? $split_milestone
        : $world['max_milestone_upbringing'];

    $point_milestone_flexible = $split_milestone < $world['max_milestone_flexible']
        ? $split_milestone
        : $world['max_milestone_flexible'];

    $point_skill = $split_skill < $world['max_skill']
        ? $split_skill
        : $world['max_skill'];

    $point_expertise = $split_expertise < $world['max_expertise']
        ? $split_expertise
        : $world['max_expertise'];

    $point_relationship = $split_relationship < $world['max_relationship']
        ? $split_relationship
        : $world['max_relationship'];

    $postData['point_supernatural'] = $point_supernatural;
    $postData['point_potential'] = 1;
    $postData['point_money'] = $point_money;
    $postData['point_skill'] = $point_skill;
    $postData['point_expertise'] = $point_expertise;
    $postData['point_milestone_upbringing'] = $point_milestone_upbringing;
    $postData['point_milestone_flexible'] = $point_milestone_flexible;
    $postData['point_characteristic_gift'] = intval($world['max_characteristic_gift']);
    $postData['point_characteristic_imperfection'] = intval($world['max_characteristic_imperfection']);
    $postData['point_relationship'] = $point_relationship;

    $result = $curl->post('person', $postData);

    return ['id' => $result['id'], 'hash' => $result['hash']];
}

function person_postDefaults($postData, $hash) {
    global $curl;

    $postArray = [];
    $money = [];

    $person = $curl->get('person/hash/'.$hash)['data'][0];

    $personId = $person['id'];
    $worldId = $person['world_id'];
    $speciesId = $person['species_id'];

    $world = $curl->get('world/id/'.$worldId)['data'][0];
    $worldDefaults = $curl->get('world-attribute/id/'.$worldId.'/species/'.$speciesId)['data'];
    $speciesList = $curl->get('species-attribute/id/'.$speciesId)['data'];

    $money[] = ['person_id' => $personId, 'attribute_id' => 19, 'value' => $postData['money']];

    foreach($worldDefaults as $attr) {
        if($attr['protected'] || $attr['attributetype_id'] == $world['skill_attributetype_id']) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $attr['id'], 'value' => $attr['default']];
        }
    }

    foreach($postArray as $key => $array) {
        foreach($speciesList as $species) {
            if($array['attribute_id'] == $species['attribute_id']) {
                $postArray[$key]['value'] += $species['value'];
            }
        }

        foreach($money as $m) {
            if($array['attribute_id'] == $m['attribute_id']) {
                $postArray[$key]['value'] += $m['value'];
            }
        }
    }

    foreach($postArray as $array) {
        $curl->post('person-attribute', $array);
    }
}

function person_putPerson($postData, $hash) {
    global $curl;

    $curl->put('person/hash/'.$hash, $postData);
}

function person_putTableAttribute($table, $tableId, $personId) {
    global $curl;

    $post = null;

    $currentList= $curl->get('person-attribute/id/'.$personId)['data'];
    $tableAttribute = $curl->get($table.'/id/'.$tableId)['data'][0];

    foreach($currentList as $current) {
        if($current['id'] == $tableAttribute['attribute_id']) {
            $value = intval($tableAttribute['attribute_value']) + intval($current['value']);

            $post = ['person_id' => $personId, 'attribute_id' => $tableAttribute['attribute_id'], 'value' => $value];
        }
    }

    if(isset($post)) {
        $curl->post('person-attribute', $post);
    }
}

function person_putExperience($experience, $personId) {
    global $curl;

    $currentExperience = $curl->get('person-attribute/id/'.$personId.'/type/9')['data'][0];

    $calc = intval($currentExperience['value']) + intval($experience);

    $post = ['person_id' => $personId, 'attribute_id' => $currentExperience['id'], 'value' => $calc];

    $curl->post('person-attribute', $post);
}

function person_postSupernaturalExpertise($postData) {
    global $curl;

    $post = ['person_id' => $postData['person_id'], 'expertise_id' => $postData['expertise_id'], 'level' => 1];

    $curl->post('person-expertise', $post);
}

function person_postCharacteristic($postData) {
    global $curl;

    $curl->post('person-characteristic',$postData);
}

function person_postMilestone($postData) {
    global $curl;

    $curl->post('person-milestone', $postData);
}

function person_postSkill($postData, $personId) {
    global $curl;

    $postArray = [];

    foreach($postData as $key => $value) {
        if($value > 0) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post('person-attribute',$post);
    }
}

function person_postExpertise($postData, $personId) {
    global $curl;

    $postArray = [];
    $attrArray = [];

    $currentList= $curl->get('person-attribute/id/'.$personId)['data'];

    foreach($postData as $key => $value) {
        if($value > 0) {
            $postArray[] = ['person_id' => $personId, 'expertise_id' => $key, 'level' => $value];

            $expertise = $curl->get('expertise/id/'.$key)['data'][0];

            if(isset($expertise['give_attribute_id'])) {
                foreach($currentList as $current) {
                    if($current['id'] == $expertise['give_attribute_id']) {
                        $newValue = intval($value) + intval($current['value']);

                        $attrArray[] = ['person_id' => $personId, 'attribute_id' => $expertise['give_attribute_id'], 'value' => $newValue];
                    }
                }
            }
        }
    }

    foreach($postArray as $post) {
        $curl->post('person-expertise', $post);
    }

    foreach($attrArray as $attr) {
        $curl->post('person-attribute', $attr);
    }
}

function person_postSupernatural($postData, $personId) {
    global $curl;

    $postArray = [];

    foreach($postData as $key => $value) {
        $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $value];
    }

    foreach($postArray as $post) {
        $curl->post('person-attribute',$post);
    }
}

function person_postWeapon($postData, $personId) {
    global $curl;

    $postArray = [];

    foreach($postData as $key => $value) {
        $postArray[] = ['person_id' => $personId, 'weapon_id' => $key, 'weaponquality_id' => 3, 'equipped' => 0];
    } // todo quality should not be hardcoded

    foreach($postArray as $post) {
        $curl->post('person-weapon', $post);
    }
}


function user_postUser($postData) {
    global $curl;

    $return = null;

    if($postData['password'] == $postData['password2']) {
        $return = $curl->post('user', $postData);
    }

    return $return;
}

function user_verifyUser($postData) {
    global $curl;

    $return = null;

    if($postData['verification']) {
        $return = $curl->post('user/verify', $postData);
    }

    return $return;
}

function user_resendVerification($postData) {
    global $curl;

    $return = null;

    if($postData['email']) {
        $return = $curl->post('user/verify/again', $postData);
    }

    return $return;
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

    setcookie('sw_user_token', $token, time() + (86400 * 30), "/");
}

function user_loginMail($postData) {
    global $curl;

    $return = null;

    if($postData['email']) {
        $return = $curl->post('user/login/mail/start', $postData);
    }

    return $return;
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

    setcookie('sw_user_token', $token, time() + (86400 * 30), "/");
}

function user_passMail($postData) {
    global $curl;

    $return = null;

    if($postData['email']) {
        $return = $curl->put('user/password/start', $postData);
    }

    return $return;
}

function user_passVerify($postData) {
    global $curl;

    $return = null;

    if($postData['verification'] && $postData['password']) {
        $return = $curl->put('user/password/set', $postData);
    }

    return $return;
}


if(isset($POST_DO) && isset($POST_RETURN)) {

    $POST_DATA = [];

    foreach($_POST as $key => $value) {
        $explode = explode('--', $key);

        if($explode[0] != 'post') {
            $POST_DATA[$explode[1]] = $value;
        }
    }

    switch($POST_DO)
    {
        default: break;

        case 'person--post':
            $result = person_postPerson($POST_DATA);
            $POST_ID = $result['id'];
            $POST_HASH = $result['hash'];
            break;

        case 'person--put':
            person_putPerson($POST_DATA, $POST_HASH);
            break;

        case 'person--defaults':
            person_postDefaults($POST_DATA, $POST_HASH);
            person_putPerson(['point_money' => 0], $POST_HASH);
            break;

        case 'person--manifestation':
            person_putPerson($POST_DATA, $POST_HASH);
            break;

        case 'person--focus':
            person_putPerson($POST_DATA, $POST_HASH);
            person_putTableAttribute('focus', $POST_DATA['focus_id'], $POST_ID);
            break;

        case 'person--supernaturalexpertise':
            person_postSupernaturalExpertise($POST_DATA);
            break;

        case 'person--caste':
            person_putPerson($POST_DATA, $POST_HASH);
            person_putTableAttribute('caste', $POST_DATA['caste_id'], $POST_ID);
            break;

        case 'person--nature':
            person_putPerson($POST_DATA, $POST_HASH);
            person_putTableAttribute('nature', $POST_DATA['nature_id'], $POST_ID);
            break;

        case 'person--identity':
            person_putPerson($POST_DATA, $POST_HASH);
            person_putTableAttribute('identity', $POST_DATA['identity_id'], $POST_ID);
            break;

        case 'person--gift':
            person_postCharacteristic($POST_DATA);
            person_putTableAttribute('characteristic', $POST_DATA['characteristic_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_characteristic_gift' => $calc], $POST_HASH);
            break;

        case 'person--imperfection':
            person_postCharacteristic($POST_DATA);
            person_putTableAttribute('characteristic', $POST_DATA['characteristic_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_characteristic_imperfection' => $calc], $POST_HASH);
            break;

        case 'person--upbringing':
            person_postMilestone($POST_DATA);
            person_putTableAttribute('milestone', $POST_DATA['milestone_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_milestone_upbringing' => $calc], $POST_HASH);
            break;

        case 'person--flexible':
            person_postMilestone($POST_DATA);
            person_putTableAttribute('milestone', $POST_DATA['milestone_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_milestone_flexible' => $calc], $POST_HASH);
            break;

        case 'person--skill':
            person_postSkill($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putExperience($calc, $POST_ID);
            person_putPerson(['point_skill' => 0], $POST_HASH);
            break;

        case 'person--expertise':
            person_postExpertise($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putExperience($calc, $POST_ID);
            person_putPerson(['point_expertise' => 0], $POST_HASH);
            break;

        case 'person--supernatural':
            person_postSupernatural($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putExperience($calc, $POST_ID);
            person_putPerson(['point_supernatural' => 0], $POST_HASH);
            break;

        case 'person--weapon':
            person_postWeapon($POST_DATA, $POST_ID);
            person_putPerson(['calculated' => 1], $POST_HASH);
            break;

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
            print_r(user_loginMail($POST_DATA));
            break;

        case 'user--login--verify':
            user_loginMailVerify($POST_DATA);
            break;

        case 'user--reset':
            print_r(user_passMail($POST_DATA));
            break;

        case 'user--password':
            user_passVerify($POST_DATA);
            break;

        case 'user--logout':
            unsetUser();
            break;
    }
}

$r = isset($POST_RETURN)
    ? $POST_RETURN.'/'
    : null;

$i = isset($POST_ID)
    ? $POST_ID.'/'
    : null;

$h = isset($POST_HASH)
    ? $POST_HASH
    : null;

echo '<a href="http://spelwerk.dev/'.$r.$i.$h.'">'.$r.$i.$h.'</a>';

redirect($r.$i.$h);