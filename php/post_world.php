<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 19/02/2017
 * Time: 09:04
 */

function world_postWorld($postData) {
    global $curl;

    $resultArray = null;

    $postData['template'] = 0;
    $postData['popularity'] = 0;
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
    $worldHash = $result['hash'];

    return [
        'id' => $worldId,
        'hash' => $worldHash,
        'name' => $postData['name']
    ];
}

function world_putWorld($postData, $worldHash) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('world/hash/'.$worldHash, $postData);

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

function world_woundAdd($postData) {
    global $curl;

    $resultArray = null;

    $post = ['name' => $postData['name'], 'popularity' => 0, 'hidden' => 1];

    $resultArray[] = $curl->post('wound', $post);

    checkError($resultArray);
}


function switch_world($do) {
    global $POST_DATA, $POST_ID, $POST_HASH, $POST_USER;

    switch($do) {
        default: break;

        case 'world--post':
            $result = world_postWorld($POST_DATA);

            $POST_ID = $result['id'];
            $POST_HASH = $result['hash'];
            $resultName = $result['name'];

            if($POST_USER) {
                user_saveWorld($POST_USER, $POST_ID, $POST_HASH); // todo save world to user
            }
            break;

        case 'world--put':
            world_putWorld($POST_DATA, $POST_HASH);
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
            world_putWorld(['calculated' => 1], $POST_HASH);
            break;
    }
}