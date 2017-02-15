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

function cookiePerson($personNickname, $personId, $personHash) {
    if($_COOKIE['sw_person_list']) {
        $cookie = unserialize($_COOKIE['sw_person_list']);
    }

    $cookie[] = ['nickname' => $personNickname, 'person_id' => $personId, 'person_hash' => $personHash];

    setcookie('sw_person_list', serialize($cookie), time() + (9 * 365 * 24 * 60 * 60));
}


function person_postPerson($postData) {
    global $curl;

    $age = intval($postData['age']);

    $world = $curl->get('world/id/'.$postData['world_id'])['data'][0];
    $item = $curl->get('species/id/'.$postData['species_id'])['data'][0];

    $defaultList = $curl->get('world-attribute/id/'.$postData['world_id'].'/species/'.$postData['species_id'])['data'];
    $speciesList = $curl->get('species-attribute/id/'.$postData['species_id'])['data'];

    $split_supernatural = floor($age / $world['split_supernatural']);
    $split_milestone = floor($age / $world['split_milestone']);
    $split_skill = floor($age / $world['split_skill']) * intval($item['multiply_skill']);
    $split_expertise = floor($age / $world['split_expertise']) * intval($item['multiply_expertise']);
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
    $postData['point_power'] = 1;
    $postData['point_money'] = $point_money;
    $postData['point_skill'] = $point_skill;
    $postData['point_expertise'] = $point_expertise;
    $postData['point_milestone_upbringing'] = $point_milestone_upbringing;
    $postData['point_milestone_flexible'] = $point_milestone_flexible;
    $postData['point_characteristic_gift'] = intval($world['max_characteristic_gift']);
    $postData['point_characteristic_imperfection'] = intval($world['max_characteristic_imperfection']);
    $postData['point_relationship'] = $point_relationship;

    $result = $curl->post('person', $postData);

    $personId = $result['id'];
    $personHash = $result['hash'];

    $postArray = [];

    foreach($defaultList as $default) {
        if($default['protected'] || $default['attributetype_id'] == $world['skill_attributetype_id']) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $default['id'], 'value' => $default['default']];
        }
    }

    foreach($postArray as $key => $array) {
        foreach($speciesList as $item) {
            if($array['attribute_id'] == $item['attribute_id']) {
                $postArray[$key]['value'] += $item['value'];
            }
        }
    }

    foreach($postArray as $array) {
        $curl->post('person-attribute', $array);
    }

    return ['id' => $personId, 'hash' => $personHash, 'nickname' => $postData['nickname']];
}

function person_putPerson($postData, $personHash) {
    global $curl;

    $curl->put('person/hash/'.$personHash, $postData);
}

function person_removeFrom($table, $thingId, $personId) {
    global $curl;

    $curl->delete('person-'.$table.'/id/'.$personId.'/id/'.$thingId);
}

function person_postTo($table, $postData) {
    global $curl;

    $curl->post('person-'.$table, $postData);
}

function person_postAttribute($postData, $personId, $allowsAll = false) {
    global $curl;

    $postArray = [];

    foreach($postData as $key => $value) {
        if($allowsAll || $value > 0) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $key, 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post('person-attribute',$post);
    }
}

function person_putAttribute($personId, $attributeId, $attributeValue) {
    global $curl;

    $newValue = intval($attributeValue);

    $current = $curl->get('person-attribute/id/'.$personId.'/attribute/'.$attributeId);

    if(isset($current['data'])) {
        $currentValue = $current['data'][0]['value'];

        $newValue += intval($currentValue);
    }

    $post = ['person_id' => $personId, 'attribute_id' => $attributeId, 'value' => $newValue];

    $curl->post('person-attribute', $post);
}

function person_putExpertise($personId, $expertiseId, $expertiseLevel) {
    global $curl;

    $newLevel = intval($expertiseLevel);

    $current = $curl->get('person-expertise/id/'.$personId.'/expertise/'.$expertiseId);

    if(isset($current['data'])) {
        $currentLevel = $current['data'][0]['level'];

        $newLevel += intval($currentLevel);
    }

    $post = ['person_id' => $personId, 'expertise_id' => $expertiseId, 'level' => $newLevel];

    $curl->post('person-expertise', $post);
}

function person_putAttributeFromTable($table, $tableId, $personId, $currentId = null) {
    global $curl;

    // first we do removal

    if(isset($currentId)) {
        $currentPost = null;

        $personList= $curl->get('person-attribute/id/'.$personId)['data'];
        $currentList = $curl->get($table.'/id/'.$currentId)['data'];

        foreach($personList as $person) {
            foreach($currentList as $current) {
                if($person['id'] == $current['attribute_id']) {
                    if(isset($current['attribute_value'])) {
                        $value = intval($person['value']) - intval($current['attribute_value']);
                    } else {
                        $value = intval($person['value']) - intval($current['value']);
                    }

                    $currentPost[] = ['person_id' => $personId, 'attribute_id' => $current['attribute_id'], 'value' => $value];
                }
            }
        }

        if(isset($currentPost)) {
            foreach($currentPost as $post) {
                $curl->post('person-attribute', $post);
            }
        }
    }

    // then we do addition

    $changePost = null;

    $personList= $curl->get('person-attribute/id/'.$personId)['data'];
    $changeList = $curl->get($table.'/id/'.$tableId)['data'];

    foreach($personList as $person) {
        foreach($changeList as $change) {
            if($person['id'] == $change['attribute_id']) {

                if(isset($change['attribute_value'])) {
                    $value = intval($person['value']) + intval($change['attribute_value']);
                } else {
                    $value = intval($person['value']) + intval($change['value']);
                }

                $changePost[] = ['person_id' => $personId, 'attribute_id' => $change['attribute_id'], 'value' => $value];
            }
        }
    }

    if(isset($changePost)) {
        foreach($changePost as $post) {
            $curl->post('person-attribute', $post);
        }
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

function person_woundAdd($postData, $personId, $woundId) {
    global $curl;

    $post = ['person_id' => $personId, 'wound_id' => $woundId, 'aid' => 0, 'heal' => 0, 'lethal' => $postData['lethal']];

    $return = $curl->post('person-wound', $post);

    return $return;
}

function person_woundAid($postData, $personId) {
    global $curl;

    $aid = $postData['aid'] == 1
        ? 0
        : 1;

    $post = ['aid' => $aid];

    print_r($curl->put('person-wound/person/'.$personId.'/wound/'.$postData['id'], $post));
}

function person_woundHeal($postData, $personId) {
    global $curl;

    $heal = $postData['heal'] == 1
        ? 0
        : 1;

    $post = ['heal' => $heal];

    print_r($curl->put('person-wound/person/'.$personId.'/wound/'.$postData['id'], $post));
}


function world_postWorld($postData) {

}

function world_woundAdd($postData) {
    global $curl;

    $post = ['name' => $postData['name'], 'popularity' => 0, 'hidden' => 1];

    $return = $curl->post('wound', $post);

    return $return;
}


function user_postUser($postData) {
    global $curl;

    if($postData['password'] == $postData['password2']) {
        $curl->post('user', $postData);
    }
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

function user_addPerson($userId, $personId, $personHash) {
    global $curl;

    $post = isset($personHash)
        ? ['user_id' => $userId, 'person_id' => $personId, 'hash' => $personHash]
        : ['user_id' => $userId, 'person_id' => $personId];

    $curl->post('user-person', $post);
}


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

    switch($POST_DO)
    {
        default: break;

        case 'person--post':
            $result = person_postPerson($POST_DATA);

            $POST_ID = $result['id'];
            $POST_HASH = $result['hash'];

            if($POST_USER) {
                user_addPerson($POST_USER, $POST_ID, $POST_HASH);
            }

            cookiePerson($result['nickname'], $POST_ID, $POST_HASH);

            break;

        case 'person--put':
            person_putPerson($POST_DATA, $POST_HASH);

            if(isset($POST_DATA['caste_id'])) {
                person_putAttributeFromTable('caste', $POST_DATA['caste_id'], $POST_ID);
            }

            if(isset($POST_DATA['nature_id'])) {
                person_putAttributeFromTable('nature', $POST_DATA['nature_id'], $POST_ID);
            }

            if(isset($POST_DATA['identity_id'])) {
                person_putAttributeFromTable('identity', $POST_DATA['identity_id'], $POST_ID);
            }

            if(isset($POST_DATA['focus_id'])) {
                person_putAttributeFromTable('focus', $POST_DATA['focus_id'], $POST_ID);
            }

            break;

        case 'person--money':
            person_putAttribute($POST_ID, $POST_DATA['attribute_id'], $POST_DATA['value']);
            person_putPerson(['point_money' => 0], $POST_HASH);
            break;

        case 'person--experience':
            $curl->post('person-attribute',['person_id' => $POST_ID, 'attribute_id' => 22, 'value' => $POST_DATA['value']]);
            break;

        case 'person--supernatural--power':
            person_putAttribute($POST_ID, $POST_DATA['attribute_id'], $POST_DATA['value']);
            person_putPerson(['point_power' => 0], $POST_HASH);
            break;

        case 'person--supernatural--expertise':
            person_putExpertise($POST_ID, $POST_DATA['expertise_id'], 1);
            break;

        case 'person--gift':
            person_postTo('characteristic', $POST_DATA);
            person_putAttributeFromTable('characteristic', $POST_DATA['characteristic_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_characteristic_gift' => $calc], $POST_HASH);
            break;

        case 'person--imperfection':
            person_postTo('characteristic', $POST_DATA);
            person_putAttributeFromTable('characteristic', $POST_DATA['characteristic_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_characteristic_imperfection' => $calc], $POST_HASH);
            break;

        case 'person--upbringing':
            person_postTo('characteristic', $POST_DATA);
            person_putAttributeFromTable('milestone', $POST_DATA['milestone_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_milestone_upbringing' => $calc], $POST_HASH);
            break;

        case 'person--flexible':
            person_postTo('characteristic', $POST_DATA);
            person_putAttributeFromTable('milestone', $POST_DATA['milestone_id'], $POST_ID);

            $calc = intval($_POST['post--points']) - 1;

            person_putPerson(['point_milestone_flexible' => $calc], $POST_HASH);
            break;

        case 'person--skill':
            person_postAttribute($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putPerson(['point_skill' => 0], $POST_HASH);

            if($_POST['post--points'] != 999) {
                person_putAttribute($POST_ID, 22, $calc); // todo experience should not be hardcoded?
            }
            break;

        case 'person--expertise':
            person_postExpertise($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putPerson(['point_expertise' => 0], $POST_HASH);

            if($_POST['post--points'] != 999) {
                person_putAttribute($POST_ID, 22, $calc); // todo experience should not be hardcoded?
            }
            break;

        case 'person--supernatural':
            person_postAttribute($POST_DATA, $POST_ID);

            $calc = intval($_POST['post--points']);

            person_putPerson(['point_supernatural' => 0], $POST_HASH);

            if($_POST['post--points'] != 999) {
                person_putAttribute($POST_ID, 22, $calc); // todo experience should not be hardcoded?
            }
            break;

        case 'person--weapon':
            person_postWeapon($POST_DATA, $POST_ID);
            person_putPerson(['calculated' => 1], $POST_HASH);
            break;

        case 'person--edit--attribute':
            person_postAttribute($POST_DATA, $POST_ID, true);
            break;

        case 'person--edit--feature':

            if(isset($POST_DATA['species_id'])) {
                person_putPerson(['species_id' => $POST_DATA['species_id']], $POST_HASH);
                person_putAttributeFromTable('species-attribute', $POST_DATA['species_id'], $POST_ID, $POST_DATA['current_id']);
            }

            if(isset($POST_DATA['caste_id'])) {
                person_putPerson(['caste_id' => $POST_DATA['caste_id']], $POST_HASH);
                person_putAttributeFromTable('caste', $POST_DATA['caste_id'], $POST_ID, $POST_DATA['current_id']);
            }

            if(isset($POST_DATA['nature_id'])) {
                person_putPerson(['nature_id' => $POST_DATA['nature_id']], $POST_HASH);
                person_putAttributeFromTable('nature', $POST_DATA['nature_id'], $POST_ID, $POST_DATA['current_id']);
            }

            if(isset($POST_DATA['identity_id'])) {
                person_putPerson(['identity_id' => $POST_DATA['identity_id']], $POST_HASH);
                person_putAttributeFromTable('identity', $POST_DATA['identity_id'], $POST_ID, $POST_DATA['current_id']);
            }

            if(isset($POST_DATA['focus_id'])) {
                person_putPerson(['focus_id' => $POST_DATA['focus_id']], $POST_HASH);
                person_putAttributeFromTable('focus', $POST_DATA['focus_id'], $POST_ID, $POST_DATA['current_id']);
            }
            break;

        case 'person--remove--thing':
            person_removeFrom($POST_DATA['table'], $POST_DATA['id'], $POST_ID);
            break;

        case 'wound--add':
            $return = world_woundAdd($POST_DATA);
            person_woundAdd($POST_DATA, $POST_ID, $return['id']);
            break;

        case 'wound--aid':
            person_woundAid($POST_DATA, $POST_ID);
            break;

        case 'wound--heal':
            person_woundHeal($POST_DATA, $POST_ID);
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

echo '<a href="http://spelwerk.dev/'.$r.$i.$h.$a.$d.'">'.$r.$i.$h.$a.$d.'</a>';

//redirect($r.$i.$h.$a.$d);