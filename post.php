<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 03/02/2017
 * Time: 11:23
 */

require_once('class/Curl.php');
require_once('php/config.php');

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

function cookie_add($type, $id, $secret) {
    $cookieName = 'sw_'.$type.'_list';
    $cookieId = $type.'_id';
    $cookieSecret = $type.'_hash';

    if(isset($_COOKIE[$cookieName])) {
        $cookie = unserialize($_COOKIE[$cookieName]);
    }

    $cookie[] = [$cookieId => $id, $cookieSecret  => $secret];

    setcookie($cookieName, serialize($cookie), time() + (9 * 365 * 24 * 60 * 60));
}

function explode_key_value($postData) {
    $return = [];

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1])) {
            $return[$explode[0]] = $explode[1];

            $return['value'] = $value;
        } else {
            $return[$key] = $value;
        }
    }

    return $return;
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

function setUser($token) {
    setcookie('sw_user_token', $token, time() + (86400 * 30), "/");
}



function manifestation_post($postData) {
    global $curl;

    $postArray = null;
    $resultArray = null;

    // Attribute Type
    $attributeTypePost = [
        'name' => $postData['name'],
        'protected' => 0,
        'maximum' => $postData['attribute_maximum']
    ];
    $attributeTypeResult = $curl->post('attributetype', $attributeTypePost);
    $attributeTypeId = $attributeTypeResult['id'];
    $resultArray[] = $attributeTypeResult;

    // Attribute for Power
    $attributePost = [
        'name' => $postData['attribute_power'],
        'protected'  => 0,
        'attributetype_id' => 7
    ];
    $attributeResult = $curl->post('attribute', $attributePost);
    $attributeId = $attributeResult['id'];
    $resultArray[] = $attributeResult;

    // Expertise
    $expertiseTypePost = [
        'name' => $postData['name'],
        'maximum' => $postData['expertise_maximum'],
        'skill_attribute_required' => $postData['skill_attribute_required'],
        'skill_attribute_increment' => $postData['skill_attribute_increment'],
        'startsat' => $postData['startsat']
    ];
    $expertiseTypeResult = $curl->post('expertisetype', $expertiseTypePost);
    $expertiseTypeId = $expertiseTypeResult['id'];
    $resultArray[] = $expertiseTypeResult;

    // Manifestation
    $postArray['name'] = $postData['name'];
    $postArray['description'] = $postData['description'];
    $postArray['attributetype_id'] = $attributeTypeId;
    $postArray['skill_attributetype_id'] = $postData['skill_attributetype_id'];
    $postArray['expertisetype_id'] = $expertiseTypeId;
    $postArray['power_attribute_id'] = $attributeId;

    $result = $curl->post('manifestation', $postArray);
    $resultArray[] = $result;

    checkError($resultArray);

    return $result;
}

function manifestation_discipline($postData, $manifestationId) {
    global $curl;

    $postArray = null;
    $resultArray = null;

    // Attribute Discipline (Give Attribute Id in Expertise)
    $attributePost = [
        'name' => $postData['name'],
        'description' => $postData['description'],
        'protected'  => 0,
        'attributetype_id' => $postData['attributetype_id'],
        'icon_id' => $postData['icon']
    ];
    $attributeResult = $curl->post('attribute', $attributePost);
    $attributeId = $attributeResult['id'];
    $resultArray[] = $attributeResult;

    // Expertise Creation of Discipline
    $expertisePost = [
        'name' => $postData['name'],
        'description' => $postData['description'],
        'hidden'  => 0,
        'expertisetype_id' => $postData['expertisetype_id'],
        'manifestation_id' => $manifestationId,
        'skill_attribute_id' => $postData['attribute_id'],
        'give_attribute_id' => $attributeId
    ];
    $expertiseResult = $curl->post('expertise', $expertisePost);
    $resultArray[] = $expertiseResult;

    checkError($resultArray);
}

function manifestation_focus($postData, $manifestationId) {
    global $curl;

    $resultArray = null;

    $post = [
        'name' => $postData['name'],
        'description' => $postData['description'],
        'attribute_id' => 3,
        'attribute_value' => 1,
        'manifestation_id' => $manifestationId,
        'icon_id' => $postData['icon']
    ];

    $resultArray[] = $curl->post('attribute', $post);

    checkError($resultArray);
}

/** PERSON */

function person_augmentation_post($postData, $bionicId, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $personSecret, 'bionic_id' => $bionicId, 'augmentation_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/augmentation',$post);
    }

    checkError($resultArray);
}

function person_attribute_post($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'attribute_id') {
            $postArray[] = ['secret' => $personSecret, 'attribute_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/attribute',$post);
    }

    checkError($resultArray);
}

function person_attribute_put($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'attribute_id') {
            $postArray[] = ['secret' => $personSecret, 'attribute_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->put('person/id/'.$personId.'/attribute',$post);
    }

    checkError($resultArray);
}

function person_bionic_post($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $personSecret, 'bionic_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/bionic',$post);
    }

    checkError($resultArray);
}

function person_expertise_post($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'expertise_id') {
            $postArray[] = ['secret' => $personSecret, 'expertise_id' => $explode[1], 'level' => $value];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/expertise',$post);
    }

    checkError($resultArray);
}

function person_protection_post($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $personSecret, 'protection_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/protection',$post);
    }

    checkError($resultArray);
}

function person_weapon_post($postData, $personId, $personSecret) {
    global $curl;

    $postArray = [];
    $resultArray = [];

    foreach($postData as $key => $value) {
        if($key == $value) {
            $postArray[] = ['secret' => $personSecret, 'weapon_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person/id/'.$personId.'/weapon',$post);
    }

    checkError($resultArray);
}

// OBSOLETE?

function person_has_edit($table, $personId, $tableId, $post) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('person-'.$table.'/id/'.$personId.'/id/'.$tableId, $post);

    checkError($resultArray);
}

function person_wound_add($postData, $personId, $contextRoute, $woundId) {
    global $curl;

    $resultArray = null;

    $idName = $contextRoute.'_id';

    $post = ['person_id' => $personId, $idName => $woundId, 'timestwo' => $postData['double']];

    $resultArray[] = $curl->post('person-'.$contextRoute, $post);

    checkError($resultArray);
}

/** STORY */

function story_add($postData) {
    global $curl;

    $resultArray = null;

    $result = $curl->post('story',$postData);
    $resultArray = $result;

    $storyId = $result['id'];
    $storySecret = $result['hash'];

    checkError($resultArray);

    return [
        'id' => $storyId,
        'hash' => $storySecret
    ];
}

function story_edit($postData, $storySecret) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('story/hash/'.$storySecret, $postData);

    checkError($resultArray);
}

function story_person_add($postData, $storyId) {
    global $curl;

    $resultArray = null;
    $personId = null;

    if(isset($postData['person_link']) && $postData['person_link'] != null) {
        $explode = explode('/',$postData['person_link']);

        $count = count($explode) - 1;

        $shouldBeInt = intval($explode[$count]);
        $shouldBeId = $explode[$count-1] == 'id'
            ? true
            : false;

        $shouldBePerson = $explode[$count-2] == 'person'
            ? true
            : false;

        $shouldBePlay = $explode[$count-3] == 'play'
            ? true
            : false;

        if($shouldBePlay && $shouldBePerson && $shouldBeId && $shouldBeInt) {
            $personId = $shouldBeInt;
        }
    } else if(isset($postData['person_id']) && $postData['person_id'] != null) {
        $personId = $postData['person_id'];
    }

    // todo add person hash
    $post = ['story_id' => $storyId, 'person_id' => $personId];

    $resultArray[] = $curl->post('story-person',$post);

    checkError($resultArray);
}

function story_has_delete($table, $thingId, $personId) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->delete('story-'.$table.'/id/'.$personId.'/id/'.$thingId);

    checkError($resultArray);
}

/** USER */

function user_add($postData) {
    global $curl;

    unsetUser();

    $result = $curl->post('user', $postData);

    $token = isset($result['token'])
        ? $result['token']
        : null;

    setUser($token);
}

function user_add_verify($postData) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->post('user/verify', $postData);

    checkError($resultArray);
}

function user_add_timeout($postData) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->post('user/verify/again', $postData);

    checkError($resultArray);
}

function user_login($postData) {
    global $curl;

    unsetUser();

    if($postData['email'] && $postData['password']) {
        $result = $curl->post('user/login/password', $postData);
    }

    $token = isset($result['token'])
        ? $result['token']
        : null;

    setUser($token);
}

function user_login_email($postData) {
    global $curl;

    $resultArray[] = null;

    if($postData['email']) {
        $resultArray[] = $curl->post('user/login/mail/start', $postData);
    }

    checkError($resultArray);
}

function user_login_email_verify($postData) {
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

function user_reset($postData) {
    global $curl;

    $resultArray = null;

    if($postData['email']) {
        $resultArray[] = $curl->put('user/password/start', $postData);
    }

    checkError($resultArray);
}

function user_reset_verify($postData) {
    global $curl;

    $resultArray = null;

    if($postData['hash'] && $postData['password']) {
        $resultArray[] = $curl->put('user/password/set', $postData);
    }

    checkError($resultArray);
}

function user_save_person($userId, $personId, $personSecret) {
    global $curl;

    $resultArray = null;

    $post = isset($personSecret)
        ? ['user_id' => $userId, 'person_id' => $personId, 'hash' => $personSecret]
        : ['user_id' => $userId, 'person_id' => $personId];

    $resultArray[] = $curl->post('user-person', $post);

    cookie_person_add($personId, $personSecret);

    checkError($resultArray);
}

function user_save_story($userId, $storyId, $storySecret) {
    global $curl;

    $resultArray = null;

    $post = isset($storySecret)
        ? ['user_id' => $userId, 'story_id' => $storyId, 'hash' => $storySecret]
        : ['user_id' => $userId, 'story_id' => $storyId];

    $resultArray[] = $curl->post('user-story', $post);

    cookie_person_add($storyId, $storySecret);

    checkError($resultArray);
}

function user_save_world($userId, $worldId, $worldSecret) {
    global $curl;

    $resultArray = null;

    $post = isset($worldSecret)
        ? ['user_id' => $userId, 'world_id' => $worldId, 'hash' => $worldSecret]
        : ['user_id' => $userId, 'world_id' => $worldId];

    $resultArray[] = $curl->post('user-world', $post);

    checkError($resultArray);
}

/** WORLD */

function world_postWorld($postData) {
    global $curl;

    $resultArray = null;

    $postData['template'] = 0;
    $postData['thumbsup'] = 0;
    $postData['thumbsdown'] = 0;
    $postData['hidden'] = 1;
    $postData['calculated'] = 0;

    $postData['split_supernatural'] = 0;
    $postData['split_skill'] = 0;
    $postData['split_expertise'] = 0;
    $postData['split_milestone'] = 0;
    $postData['split_relationship'] = 0;

    $postData['max_characteristic_gift'] = 0;
    $postData['max_characteristic_imperfection'] = 0;
    $postData['max_supernatural'] = 0;
    $postData['max_skill'] = 0;
    $postData['max_expertise'] = 0;
    $postData['max_milestone'] = 0;
    $postData['max_relationship'] = 0;

    $result = $curl->post('world', $postData);

    $worldId = $result['id'];
    $worldSecret = $result['hash'];

    return [
        'id' => $worldId,
        'hash' => $worldSecret,
        'name' => $postData['name']
    ];
}

function world_putWorld($postData, $worldSecret) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('world/hash/'.$worldSecret, $postData);

    checkError($resultArray);
}

function world_has($postData, $worldId, $thing) {
    global $curl;

    $resultArray = null;
    $postArray = null;

    $get = 'world-'.$thing;

    foreach($postData as $key => $value) {
        $post = ['world_id' => $worldId, $thing.'_id' => $value];

        $resultArray[] = $curl->post($get, $post);
    }

    checkError($resultArray);
}

function world_hasDefault($postData, $worldId) {
    global $curl;

    $resultArray = null;
    $protectedList = $curl->get('attribute/protected')['data'];

    foreach($protectedList as $attribute) {
        $defaultValue = 0;

        foreach($postData as $key => $value) {
            $explode = explode('__', $key);

            if($attribute['id'] == $explode[1]) {
                $defaultValue = $value;
            }
        }

        $post = ['world_id' => $worldId, 'attribute_id' => $attribute['id'], 'default_value' => $defaultValue];

        $resultArray[] = $curl->post('world-attribute', $post);
    }

    checkError($resultArray);
}

function world_hasSkill($postData, $worldId) {
    global $curl;

    $resultArray = null;
    $postArray = null;

    foreach($postData as $key => $value) {
        $post = ['world_id' => $worldId, 'attribute_id' => $value, 'default_value' => 0];

        $resultArray[] = $curl->post('world-attribute', $post);
    }

    checkError($resultArray);
}

function world_hasExpertise($postData, $worldId) {
    global $curl;

    $resultArray = null;
    $postArray = null;

    foreach($postData as $key => $value) {
        $post = ['world_id' => $worldId, 'expertise_id' => $value];

        $resultArray[] = $curl->post('world-expertise', $post);
    }

    checkError($resultArray);
}

function world_hasManifestation($postData, $worldId) {
    global $curl;

    $resultArray = null;
    $attributeArray = null;
    $expertiseArray = null;
    $focusArray = null;

    foreach($postData as $key => $id) {
        $manifestation = $curl->get('manifestation/id/'.$id)['data'][0];
        $attributeList = $curl->get('attribute/type/'.$manifestation['attributetype_id'])['data'];
        $expertiseList = $curl->get('expertise/type/'.$manifestation['expertisetype_id'])['data'];
        $focusList = $curl->get('focus')['data'];

        $post = ['world_id' => $worldId, 'manifestation_id' => $id];

        $resultArray[] = $curl->post('world-manifestation', $post);

        foreach($attributeList as $item) {
            $post = ['world_id' => $worldId, 'attribute_id' => $item['id'], 'default_value' => 0];

            $resultArray[] = $curl->post('world-attribute', $post);
        }

        foreach($expertiseList as $item) {
            $post = ['world_id' => $worldId, 'expertise_id' => $item['id']];

            $resultArray[] = $curl->post('world-expertise', $post);
        }

        foreach($focusList as $item) {
            $post = ['world_id' => $worldId, 'focus_id' => $item['id']];

            $resultArray[] = $curl->post('world-focus', $post);
        }
    }

    checkError($resultArray);
}

function world_wound_add($postData, $contextRoute) {
    global $curl;

    $resultArray = null;

    $post = ['name' => $postData['name']];

    $resultArray[] = $curl->post($contextRoute, $post);

    checkError($resultArray);

    return $resultArray[0]['id'];
}

/** SWITCHES */

function switch_manifestation($do) {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_USER;

    switch($do) {
        default: break;

        case 'manifestation--post':
            $result = manifestation_post($POST_DATA);
            $POST_ID = $result['id'];
            break;

        case 'manifestation--discipline':
            manifestation_discipline($POST_DATA, $POST_ID);
            break;

        case 'manifestation--focus':
            manifestation_focus($POST_DATA, $POST_ID);
            break;
    }
}

function switch_person($do) {
    global $curl, $POST_ID, $POST_SECRET, $POST_USER, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        // New API

        case 'person--add':
            $POST_DATA['playable'] = 1;

            $result = $curl->post('person',$POST_DATA);
            $POST_ID = $result['id'];
            $POST_SECRET = $result['secret'];

            if($POST_USER) {
                user_save_person($POST_USER, $POST_ID, $POST_SECRET);
            }

            cookie_add('person',$POST_ID, $POST_SECRET);
            break;

        case 'person--augmentation':
            person_augmentation_post($POST_DATA, $POST_CONTEXT, $POST_ID, $POST_SECRET);
            break;

        case 'person--background':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/background',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--bionic':
            person_bionic_post($POST_DATA, $POST_ID, $POST_SECRET);
            break;

        case 'person--bionic--custom':
            break;

        case 'person--cheat':
            $resultArray = [];

            $POST_DATA['cheated'] = 1;
            $POST_DATA['popularity'] = 0;
            $POST_DATA['thumbsup'] = 0;
            $POST_DATA['thumbsdown'] = 0;

            $resultArray[] = $curl->put('person/id/'.$POST_ID,$POST_DATA);

            checkError($resultArray);
            break;

        case 'person--describe':
            $resultArray = [];

            $POST_DATA['calculated'] = 1;

            $resultArray[] = $curl->put('person/id/'.$POST_ID,$POST_DATA);

            checkError($resultArray);
            break;

        case 'person--edit--description':
            $resultArray = [];

            $resultArray[] = $curl->put('person/id/'.$POST_ID,$POST_DATA);

            checkError($resultArray);
            break;

        case 'person--attribute':
            person_attribute_post($POST_DATA, $POST_ID, $POST_SECRET);
            break;

        case 'person--attribute--money':
            person_attribute_put($POST_DATA, $POST_ID, $POST_SECRET);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_money' => 0]);
            checkError($resultArray);
            break;

        case 'person--attribute--skill':
            person_attribute_put($POST_DATA, $POST_ID, $POST_SECRET);

            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_skill' => 0]);

            if(isset($_POST['post--experience'])) {
                $resultArray[] = $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--characteristic--gift':
            $calc = intval($_POST['post--points']) - 1;
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/characteristic',$POST_DATA);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_gift' => $calc]);
            checkError($resultArray);
            break;

        case 'person--characteristic--imperfection':
            $calc = intval($_POST['post--points']) - 1;
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/characteristic',$POST_DATA);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_imperfection' => $calc]);
            checkError($resultArray);
            break;

        case 'person--characteristic--custom':
            break;

        case 'person--characteristic--delete':
            $curl->delete('person/id/'.$POST_ID.'/characteristic/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--expertise':
            person_expertise_post($POST_DATA, $POST_ID, $POST_SECRET);

            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_expertise' => 0]);

            if(isset($_POST['post--experience'])) {
                $resultArray[] = $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--expertise--custom':
            break;

        case 'person--expertise--delete':
            $curl->delete('person/id/'.$POST_ID.'/expertise/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--focus':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/focus',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--identity':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/identity',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--manifestation':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/manifestation',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--manifestation--doctrine':
            person_attribute_post($POST_DATA, $POST_ID, $POST_SECRET);

            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_supernatural' => 0]);

            if(isset($_POST['post--experience'])) {
                $resultArray[] = $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--manifestation--expertise':
            $post = ['expertise_id__'.$POST_DATA['expertise_id'] => 1];
            person_expertise_post($post, $POST_ID, $POST_SECRET);
            break;

        case 'person--manifestation--power':
            person_attribute_put($POST_DATA, $POST_ID, $POST_SECRET);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_power' => 0]);
            checkError($resultArray);
            break;

        case 'person--milestone':
            $calc = intval($_POST['post--points']) - 1;
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/milestone',$POST_DATA);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_milestone' => $calc]);
            checkError($resultArray);
            break;

        case 'person--milestone--custom':
            break;

        case 'person--milestone--delete':
            $curl->delete('person/id/'.$POST_ID.'/milestone/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--nature':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/nature',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--protection':
            person_protection_post($POST_DATA, $POST_ID, $POST_SECRET);
            break;

        case 'person--protection--custom':
            break;

        case 'person--protection--equip':
            $curl->put('person/id/'.$POST_ID.'/protection/'.$POST_CONTEXT.'/equip/'.$POST_EXTRA,['secret' => $POST_SECRET]);
            break;

        case 'person--protection--delete':
            $curl->delete('person/id/'.$POST_ID.'/protection/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--species':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/species',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--weapon':
            person_weapon_post($POST_DATA, $POST_ID, $POST_SECRET);
            break;

        case 'person--weapon--custom':
            break;

        case 'person--weapon--equip':
            $curl->put('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT.'/equip/'.$POST_EXTRA,['secret' => $POST_SECRET]);
            break;

        case 'person--weapon--delete':
            $curl->delete('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--wound':
            print_r($POST_DATA);
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/'.$POST_CONTEXT,$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--wound--heal':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2.'/heal/'.$POST_EXTRA,$POST_DATA);
            checkError($resultArray);
            break;
    }
}

function switch_story($do) {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_USER, $POST_ERROR;

    switch($do) {
        default: break;

        case 'story--add':
            $result = story_add($POST_DATA);

            if(!$POST_ERROR) {
                $POST_ID = $result['id'];
                $POST_SECRET = $result['hash'];

                if($POST_USER) {
                    user_save_story($POST_USER, $POST_ID, $POST_SECRET);
                }

                cookie_add('story',$POST_ID,$POST_SECRET);
            }
            break;

        case 'story--edit':
            story_edit($POST_DATA, $POST_SECRET);
            break;

        case 'story--person--add':
            story_person_add($POST_DATA, $POST_ID);
            break;

        case 'story--delete--has':
            story_has_delete($POST_DATA['table'], $POST_DATA['id'], $POST_ID);
            break;
    }
}

function switch_user($do) {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_USER;

    switch($do) {
        default: break;

        case 'user--add':
            user_add($POST_DATA);
            break;

        case 'user--add--timeout':
            user_add_timeout($POST_DATA);
            break;

        case 'user--login':
            user_login($POST_DATA);
            break;

        case 'user--login--email':
            user_login_email($POST_DATA);
            break;

        case 'user--reset':
            user_reset($POST_DATA);
            break;

        case 'user--verify--add':
            user_add_verify($POST_DATA);
            break;

        case 'user--verify--login':
            user_login_email_verify($POST_DATA);
            break;

        case 'user--verify--reset':
            user_reset_verify($POST_DATA);
            break;

        case 'user--logout':
            unsetUser();
            break;

        case 'user--save--person':
            user_save_person($POST_USER, $POST_ID, $POST_SECRET);
            break;
    }
}

function switch_world($do) {
    global $POST_DATA, $POST_ID, $POST_SECRET, $POST_CONTEXT, $POST_USER;

    switch($do) {
        default: break;

        case 'world--post':
            $result = world_postWorld($POST_DATA);

            $POST_ID = $result['id'];
            $POST_SECRET = $result['hash'];
            $resultName = $result['name'];

            if($POST_USER) {
                user_save_world($POST_USER, $POST_ID, $POST_SECRET); // todo save world to user
            }
            break;

        case 'world--put':
            world_putWorld($POST_DATA, $POST_SECRET);
            break;

        case 'world--has':
            world_has($POST_DATA, $POST_ID, $_POST['post--thing']);
            break;

        case 'world--default':
            world_hasDefault($POST_DATA, $POST_ID);
            break;

        case 'world--skill':
            world_hasSkill($POST_DATA, $POST_ID);
            break;

        case 'world--expertise':
            world_hasExpertise($POST_DATA, $POST_ID);
            break;

        case 'world--manifestation':
            world_hasManifestation($POST_DATA, $POST_ID);
            break;

        case 'world--augmentation':
            world_has($POST_DATA, $POST_ID, 'augmentation');
            world_putWorld(['calculated' => 1], $POST_SECRET);
            break;
    }
}

/** MAIN SWITCH */

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

    if(isset($POST_SECRET)) {
        $POST_DATA['secret'] = $POST_SECRET;
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

        case 'story':
            switch_story($POST_DO);
            break;

        case 'user':
            switch_user($POST_DO);
            break;

        case 'world':
            switch_world($POST_DO);
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
    redirect($baseUrl.$r.$i.$h.$a.$d);
} else {
    print_r($POST_ERROR);
}

echo '<a href="'.$baseUrl.$r.$i.$h.$a.$d.'">'.$baseUrl.$r.$i.$h.$a.$d.'</a>';