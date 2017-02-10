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
    header('Location: http://spelwerk.dev'.$url, true, 303);
    ob_end_flush();
    exit;
}

function person_postPerson($postData) {
    global $curl;

    $result = $curl->post('person', $postData);

    $postList = [];

    $world = $curl->get('world/id/'.$postData['world_id'])['data'][0];
    $worldDefaults = $curl->get('world-attribute/id/'.$postData['world_id'].'/species/'.$postData['species_id'])['data'];
    $speciesList = $curl->get('species-attribute/id/'.$postData['species_id'])['data'];

    foreach($worldDefaults as $attr) {
        if($attr['protected'] || $attr['attributetype_id'] == $world['skill_attributetype_id']) {
            $postList[] = ['attribute_id' => $attr['id'], 'value' => $attr['default']];
        }
    }

    foreach($postList as $key => $array) {
        foreach($speciesList as $species) {
            if($array['attribute_id'] == $species['attribute_id']) {
                $postList[$key]['value'] += $species['value'];
            }
        }
    }

    foreach($postList as $key => $value) {
        $postList[$key]['person_id'] = $result['id'];
    }

    foreach($postList as $array) {
        $curl->post('person-attribute', $array);
    }

    return $result['hash'];
}

function person_putPerson($postData, $hash) {
    global $curl;

    $curl->put('person/hash/'.$hash, $postData);
}

function person_putTableAttribute($table, $tableId, $hash = null, $id = null) {
    global $curl;

    $person = null;
    $post = null;

    $id = isset($hash)
        ? $curl->get('person/hash/'.$hash)['data'][0]['id']
        : $id;

    $currentList= $curl->get('person-attribute/id/'.$id)['data'];
    $tableAttribute = $curl->get($table.'/id/'.$tableId)['data'][0];

    foreach($currentList as $current) {
        if($current['id'] == $tableAttribute['attribute_id']) {
            $value = intval($tableAttribute['attribute_value']) + intval($current['value']);

            $post = ['person_id' => $id, 'attribute_id' => $tableAttribute['attribute_id'], 'value' => $value];
        }
    }

    if(isset($post)) {
        $curl->post('person-attribute', $post);
    }
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

    $curl->post('person-milestone',$postData);
}

function person_postSkill($postData) {
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

function person_postExpertise($postData) {
    global $curl;

    $postArray = [];
    $attrArray = [];

    $personId = $postData['person_id'];
    $currentList= $curl->get('person-attribute/id/'.$personId)['data'];

    foreach($postData as $key => $value) {
        if($key !== 'person_id' && $value > 0) {
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

function person_postSupernatural($postData) {
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

function person_postWeapon($postData) {
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
            $POST_HASH = person_postPerson($postData);
            break;

        case 'person--put':
            person_putPerson($postData, $POST_HASH);
            break;

        case 'person--manifestation':
            person_putPerson($postData, $POST_HASH);
            break;

        case 'person--focus':
            person_putPerson($postData, $POST_HASH);
            person_putTableAttribute('focus', $postData['focus_id'], $POST_HASH);
            break;

        case 'person--supernaturalexpertise':
            person_postSupernaturalExpertise($postData);
            break;

        case 'person--caste':
            person_putPerson($postData, $POST_HASH);
            person_putTableAttribute('caste', $postData['caste_id'], $POST_HASH);
            break;

        case 'person--nature':
            person_putPerson($postData, $POST_HASH);
            person_putTableAttribute('nature', $postData['nature_id'], $POST_HASH);
            break;

        case 'person--identity':
            person_putPerson($postData, $POST_HASH);
            person_putTableAttribute('identity', $postData['identity_id'], $POST_HASH);
            break;

        case 'person--characteristic':
            person_postCharacteristic($postData);
            person_putTableAttribute('characteristic', $postData['characteristic_id'], null, $postData['person_id']);
            break;

        case 'person--milestone':
            person_postMilestone($postData);
            person_putTableAttribute('milestone', $postData['milestone_id'], null, $postData['person_id']);
            break;

        case 'person--skill':
            person_postSkill($postData);
            break;

        case 'person--expertise':
            person_postExpertise($postData);
            break;

        case 'person--supernatural':
            person_postSupernatural($postData);
            break;

        case 'person--weapon':
            person_postWeapon($postData);
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
    ? $POST_HASH
    : null;

echo '<a href="http://spelwerk.dev'.$r.$h.'">http://spelwerk.dev/'.$h.'</a>';

//redirect($r.$h);