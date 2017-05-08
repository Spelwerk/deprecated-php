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

    $cookieId = $type.'_id';

    $cookieSecret = isset($secret)
        ? $type.'_hash'
        : null;

    if(isset($_COOKIE[$cookieName])) {
        $cookie = unserialize($_COOKIE[$cookieName]);
    }

    $cookie[] = isset($secret)
        ? [$cookieId => $id, $cookieSecret  => $secret]
        : [$cookieId => $id];

    setcookie($cookieName, serialize($cookie), time() + (9 * 365 * 24 * 60 * 60));
}




/** MANIFESTATION */

// todo REWORK

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

function person_expertise_post($postData) {
    global $curl, $POST_ID, $POST_SECRET;

    $postArray = [];

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'expertise_id') {
            $postArray[] = ['secret' => $POST_SECRET, 'expertise_id' => $explode[1], 'level' => $value];
        }
    }

    foreach($postArray as $post) {
        $curl->post('person/id/'.$POST_ID.'/expertise',$post);
    }
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

/** STORY */

// todo REWORK

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

function user_save($postContext, $userId, $saveId, $saveSecret, $saveOwner) {
    global $curl;

    $contextRoute = 'user-'.$postContext;
    $contextUnderscore = $postContext.'_id';

    $post = isset($saveSecret)
        ? ['user_id' => $userId, $contextUnderscore => $saveId, 'owner' => $saveOwner, 'secret' => $saveSecret]
        : ['user_id' => $userId, $contextUnderscore => $saveId, 'owner' => $saveOwner];

    $curl->post($contextRoute,$post);
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

// WORLD

function world_has_post() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $curl;

    $postArray = [];
    $resultArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('world/id/'.$POST_ID.'/'.$POST_CONTEXT,$post,$USER_TOKEN);
    }

    checkError($resultArray);
}

function world_attribute_post() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $curl;

    $postArray = [];
    $resultArray = [];

    foreach($POST_DATA as $key => $value) {
        $explode = explode('__', $key);

        if(isset($explode[1]) && $explode[0] == 'attribute') {
            $postArray[] = ['insert_id' => $explode[1], 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('world/id/'.$POST_ID.'/attribute',$post,$USER_TOKEN);
    }

    checkError($resultArray);
}

function world_skill_post() {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $curl;

    $postArray = [];
    $resultArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = ['insert_id' => $key];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('world/id/'.$POST_ID.'/skill', $post, $USER_TOKEN);
    }

    checkError($resultArray);
}

// TABLE

function table_has_delete($tableName) {
    global $POST_DATA, $USER_TOKEN, $POST_ID, $POST_CONTEXT, $curl;

    $postArray = [];

    foreach($POST_DATA as $key => $value) {
        if($key == $value) {
            $postArray[] = $key;
        }
    }

    foreach($postArray as $post) {
        $curl->delete($tableName.'/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$post, null, $USER_TOKEN);
    }
}

/** SWITCHES */

function switch_basic($do) {
    global $curl, $POST_ID, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do)
    {
        default: break;

        case 'basic--expertise--post':
            $result = $curl->post('expertise', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--gift--post':
            $result = $curl->post('gift', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--imperfection--post':
            $result = $curl->post('imperfection', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--milestone--post':
            $result = $curl->post('milestone', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--skill--post':
            $result = $curl->post('skill', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'basic--weapon--post':
            $result = $curl->post('weapon', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;
    }
}

function switch_manifestation($do) {
    global $curl, $POST_ID, $POST_SECRET, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

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
    global $curl, $POST_ID, $POST_SECRET, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'person--post':
            $POST_DATA['playable'] = 1;

            print_r($POST_DATA);

            $result = $curl->post('person',$POST_DATA,$USER_TOKEN);

            print_r($result);

            $POST_ID = $result['id'];
            $POST_SECRET = $result['secret'];

            cookie_add('person',$POST_ID, $POST_SECRET);
            break;

        case 'person--augmentation':
            person_augmentation_post($POST_DATA, $POST_CONTEXT, $POST_ID, $POST_SECRET);
            break;

        case 'person--background':
            $curl->put('person/id/'.$POST_ID.'/background',$POST_DATA);
            break;

        case 'person--bionic':
            person_bionic_post($POST_DATA, $POST_ID, $POST_SECRET);
            break;

        case 'person--bionic--custom': // todo
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

        case 'person--characteristic--delete':
            $curl->delete('person/id/'.$POST_ID.'/characteristic/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--expertise':
            person_expertise_post($POST_DATA);

            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_expertise' => 0]);

            if(isset($_POST['post--experience'])) {
                $resultArray[] = $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--expertise--custom': // todo
            break;

        case 'person--expertise--delete':
            $curl->delete('person/id/'.$POST_ID.'/expertise/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--focus':
            $resultArray = [];
            $resultArray[] = $curl->put('person/id/'.$POST_ID.'/focus',$POST_DATA);
            checkError($resultArray);
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
            $curl->put('person/id/'.$POST_ID.'/identity',$POST_DATA);
            break;

        case 'person--manifestation':
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/manifestation',$POST_DATA);
            checkError($resultArray);
            break;

        case 'person--manifestation--doctrine':
            person_attribute_post($POST_DATA, $POST_ID, $POST_SECRET);

            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_supernatural' => 0]);

            if(isset($_POST['post--experience'])) {
                $curl->put('person/id/'.$POST_ID.'/attribute',['secret' => $POST_SECRET, 'attribute_id' => $_POST['post--experience'], 'value' => $_POST['post--points']]);
            }
            break;

        case 'person--manifestation--expertise':
            $post = ['expertise_id__'.$POST_DATA['expertise_id'] => 1];
            person_expertise_post($post);
            break;

        case 'person--manifestation--power':
            person_attribute_put($POST_DATA, $POST_ID, $POST_SECRET);
            $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_power' => 0]);
            break;

        case 'person--milestone':
            $calc = intval($_POST['post--points']) - 1;
            $resultArray = [];
            $resultArray[] = $curl->post('person/id/'.$POST_ID.'/milestone',$POST_DATA);
            $resultArray[] = $curl->put('person/id/'.$POST_ID,['secret' => $POST_SECRET, 'point_milestone' => $calc]);
            checkError($resultArray);
            break;

        case 'person--milestone--custom': // todo
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

        case 'person--protection--custom': // todo
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

        case 'person--weapon--custom': // todo
            break;

        case 'person--weapon--equip':
            $curl->put('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT.'/equip/'.$POST_EXTRA,['secret' => $POST_SECRET]);
            break;

        case 'person--weapon--delete':
            $curl->delete('person/id/'.$POST_ID.'/weapon/'.$POST_CONTEXT,['secret' => $POST_SECRET]);
            break;

        case 'person--wound':
            $curl->post('person/id/'.$POST_ID.'/'.$POST_CONTEXT,$POST_DATA);
            break;

        case 'person--wound--heal':
            $curl->put('person/id/'.$POST_ID.'/'.$POST_CONTEXT.'/'.$POST_CONTEXT2.'/heal/'.$POST_EXTRA,$POST_DATA);
            break;
    }
}

function switch_species($do) {
    global $curl, $POST_ID, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'species--post':
            $result = $curl->post('species', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'species--attribute':
            $curl->post('species/id/'.$POST_ID.'/attribute', $POST_DATA, $USER_TOKEN);
            break;

        case 'species--has--delete':
            table_has_delete('species');
            break;
    }
}

function switch_story($do) {
    global $curl, $POST_ID, $POST_SECRET, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'story--add':
            $result = story_add($POST_DATA);

            $POST_ID = $result['id'];
            $POST_SECRET = $result['hash'];

            cookie_add('story',$POST_ID,$POST_SECRET);
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
            user_save($POST_CONTEXT, $user->id, $POST_ID, $POST_SECRET, $POST_EXTRA);
            break;
    }
}

function switch_world($do) {
    global $curl, $POST_ID, $USER_TOKEN, $POST_DATA, $POST_CONTEXT, $POST_CONTEXT2, $POST_EXTRA, $POST_EXTRA2;

    switch($do) {
        default: break;

        case 'world--post':
            $result = $curl->post('world', $POST_DATA, $USER_TOKEN);
            $POST_ID = $result['id'];
            break;

        case 'world--put':
            $curl->put('world/id/'.$POST_ID, $POST_DATA, $USER_TOKEN);
            break;

        case 'world--attribute':
            world_attribute_post();
            break;

        case 'world--has--add':
            world_has_post();
            break;

        case 'world--has--delete':
            table_has_delete('world');
            break;

        case 'world--skill':
            world_skill_post();
            break;

        case 'world--calculated':
            $curl->put('world/id/'.$POST_ID,['calculated' => 1],$USER_TOKEN);
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

        case 'manifestation':
            switch_manifestation($POST_DO);
            break;

        case 'person':
            switch_person($POST_DO);
            break;

        case 'species':
            switch_species($POST_DO);
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
    //redirect($baseUrl.$r.$i.$h.$a.$d);
} else {
    print_r($POST_ERROR);
}

echo '<a href="'.$baseUrl.$r.$i.$h.$a.$d.'">'.$baseUrl.$r.$i.$h.$a.$d.'</a>';