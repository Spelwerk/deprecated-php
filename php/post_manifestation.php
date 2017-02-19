<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 19/02/2017
 * Time: 09:04
 */

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


function switch_manifestation($do) {
    global $POST_DATA, $POST_ID, $POST_HASH, $POST_USER;

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