<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 19/02/2017
 * Time: 09:04
 */

function cookiePerson($personNickname, $personId, $personHash) {
    if(isset($_COOKIE['sw_person_list'])) {
        $cookie = unserialize($_COOKIE['sw_person_list']);
    }

    $cookie[] = ['name' => $personNickname, 'person_id' => $personId, 'person_hash' => $personHash];

    setcookie('sw_person_list', serialize($cookie), time() + (9 * 365 * 24 * 60 * 60));
}


function person_postPerson($postData) {
    global $curl;

    $postArray = null;
    $resultArray = null;

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

    $point_money = $split_milestone < $world['max_milestone']
        ? $split_milestone
        : $world['max_milestone'];

    $point_milestone = $split_milestone < $world['max_milestone']
        ? $split_milestone
        : $world['max_milestone'];

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
    $postData['point_milestone'] = $point_milestone;
    $postData['point_characteristic_gift'] = intval($world['max_characteristic_gift']);
    $postData['point_characteristic_imperfection'] = intval($world['max_characteristic_imperfection']);
    $postData['point_relationship'] = $point_relationship;

    $result = $curl->post('person', $postData);

    $personId = $result['id'];
    $personHash = $result['hash'];

    foreach($defaultList as $default) {
        if($default['protected'] || $default['attributetype_id'] == $world['skill_attributetype_id']) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $default['id'], 'value' => $default['default_value']];
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
        $resultArray[] = $curl->post('person-attribute', $array);
    }

    checkError($resultArray);

    return [
        'id' => $personId,
        'hash' => $personHash,
        'nickname' => $postData['nickname']
    ];
}

function person_putPerson($postData, $personHash) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('person/hash/'.$personHash, $postData);

    checkError($resultArray);
}

function person_removeFrom($table, $thingId, $personId) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->delete('person-'.$table.'/id/'.$personId.'/id/'.$thingId);

    checkError($resultArray);
}

function person_postTo($table, $postData) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->post('person-'.$table, $postData);

    checkError($resultArray);
}

function person_putTable($table, $personId, $tableId, $post) {
    global $curl;

    $resultArray = null;

    $resultArray[] = $curl->put('person-'.$table.'/id/'.$personId.'/id/'.$tableId, $post);

    checkError($resultArray);
}

function person_postAttribute($postData, $personId, $allowsAll = false) {
    global $curl;

    $postArray = null;
    $resultArray = null;

    foreach($postData as $key => $value) {
        $explode = explode('__', $key);
        $attributeId = $explode[1];

        if($allowsAll || $value > 0) {
            $postArray[] = ['person_id' => $personId, 'attribute_id' => $attributeId, 'value' => $value];
        }
    }

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person-attribute',$post);
    }

    checkError($resultArray);
}

function person_putAttribute($personId, $attributeId, $attributeValue) {
    global $curl;

    $resultArray = null;
    $newValue = intval($attributeValue);

    $current = $curl->get('person-attribute/id/'.$personId.'/attribute/'.$attributeId);

    if(isset($current['data'])) {
        $currentValue = $current['data'][0]['value'];

        $newValue += intval($currentValue);
    }

    $post = ['person_id' => $personId, 'attribute_id' => $attributeId, 'value' => $newValue];

    $resultArray[] = $curl->post('person-attribute', $post);

    checkError($resultArray);
}

function person_putAttributeFromTable($table, $tableId, $personId, $currentId = null) {
    global $curl;

    $resultArray = null;

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
                $resultArray[] = $curl->post('person-attribute', $post);
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
            $resultArray[] = $curl->post('person-attribute', $post);
        }
    }

    checkError($resultArray);
}

function person_postAugmentation($postData, $personId) {
    global $curl;

    $resultArray = null;
    $returnArray = null;
    $postAugmentation = null;
    $postAttribute = null;
    $postWeapon = null;

    foreach($postData as $key => $value) {
        $postAugmentation[] = ['person_id' => $personId, 'augmentation_id' => $key, 'augmentationquality_id' => 4];

        $augmentation = $curl->get('augmentation/id/'.$key)['data'][0];

        if(isset($augmentation['attribute_id'])) {
            $currentValue = $curl->get('person-attribute/id/'.$personId.'/attribute/'.$augmentation['attribute_id'])['data'][0]['value'];

            $newValue = intval($augmentation['attribute_value']) + intval($currentValue);

            $postAttribute[] = ['person_id' => $personId, 'attribute_id' => $augmentation['attribute_id'], 'value' => $newValue];
        }

        if(isset($augmentation['weapon_id'])) {
            $postWeapon[] = ['person_id' => $personId, 'weapon_id' => $augmentation['weapon_id'], 'weaponquality_id' => 3, 'equipped' => 1];
        }
    }

    if(isset($postAugmentation)) {
        foreach($postAugmentation as $post) {
            $resultArray[] = $curl->post('person-augmentation', $post);
        }
    }

    if(isset($postAttribute)) {
        foreach($postAttribute as $post) {
            $resultArray[] = $curl->post('person-attribute', $post);
        }
    }

    if(isset($postWeapon)) {
        foreach($postWeapon as $post) {
            $resultArray[] = $curl->post('person-weapon', $post);
        }
    }

    checkError($resultArray);
}

function person_postBionic($postData, $personId) {
    global $curl;

    $resultArray = null;
    $postBionic = null;
    $postAttribute = null;

    foreach($postData as $key => $value) {
        $postBionic[] = ['person_id' => $personId, 'bionic_id' => $key, 'bionicquality_id' => 4];

        $bionic = $curl->get('bionic/id/'.$key)['data'][0];

        if(isset($bionic['attribute_id'])) {
            $currentValue = $curl->get('person-attribute/id/'.$personId.'/attribute/'.$bionic['attribute_id'])['data'][0]['value'];

            $newValue = intval($bionic['attribute_value']) + intval($currentValue);

            $postAttribute[] = ['person_id' => $personId, 'attribute_id' => $bionic['attribute_id'], 'value' => $newValue];
        }
    }

    if(isset($postBionic)) {
        foreach($postBionic as $post) {
            $resultArray[] = $curl->post('person-bionic', $post);
        }
    }

    if(isset($postAttribute)) {
        foreach($postAttribute as $post) {
            $resultArray[] = $curl->post('person-attribute', $post);
        }
    }

    checkError($resultArray);
}

function person_postExpertise($postData, $personId) {
    global $curl;

    $resultArray = null;
    $postExpertise = null;
    $postAttribute = null;

    foreach($postData as $key => $value) {
        if($value > 0) {
            $previousLevel = 0;

            $expertise = $curl->get('expertise/id/'.$key)['data'][0];
            $currentExpertise = $curl->get('person-expertise/id/'.$personId.'/expertise/'.$key);

            if(isset($currentExpertise['data'][0])) {
                $previousLevel = $currentExpertise['data'][0]['level'];
            }

            $postExpertise[] = ['person_id' => $personId, 'expertise_id' => $key, 'level' => $value];

            if(isset($expertise['give_attribute_id'])) {
                $currentValue = $curl->get('person-attribute/id/'.$personId.'/attribute/'.$expertise['give_attribute_id'])['data'][0]['value'];

                $newValue = intval($value) + intval($currentValue) - intval($previousLevel);

                $postAttribute[] = ['person_id' => $personId, 'attribute_id' => $expertise['give_attribute_id'], 'value' => $newValue];
            }
        }
    }

    if(isset($postExpertise)) {
        foreach($postExpertise as $post) {
            $resultArray[] = $curl->post('person-expertise', $post);
        }
    }

    if(isset($postAttribute)) {
        foreach($postAttribute as $post) {
            $resultArray[] = $curl->post('person-attribute', $post);
        }
    }

    checkError($resultArray);
}

function person_postProtection($postData, $personId) {
    global $curl;

    $resultArray = null;
    $postArray = null;

    foreach($postData as $key => $value) {
        $postArray[] = ['person_id' => $personId, 'protection_id' => $key, 'protectionquality_id' => 3, 'equipped' => 1];
    } // todo quality should not be hardcoded

    foreach($postArray as $post) {
        $resultArray[] = $curl->post('person-protection', $post);
    }

    checkError($resultArray);
}

function person_postWeapon($postData, $personId) {
    global $curl;

    $resultArray = null;
    $postArray = null;

    foreach($postData as $key => $value) {
        $post = ['person_id' => $personId, 'weapon_id' => $key, 'weaponquality_id' => 3, 'equipped' => 1];

        $resultArray[] = $curl->post('person-weapon', $post);
    }

    // todo quality should not be hardcoded

    checkError($resultArray);
}

function person_woundAdd($postData, $personId, $woundId) {
    global $curl;

    $resultArray = null;

    $post = ['person_id' => $personId, 'wound_id' => $woundId, 'aid' => 0, 'heal' => 0, 'lethal' => $postData['lethal']];

    $resultArray[] = $curl->post('person-wound', $post);

    checkError($resultArray);
}


function switch_person($do) {
    global $POST_DATA, $POST_ID, $POST_HASH, $POST_USER, $POST_ERROR;

    switch($do) {
        default: break;

        case 'person--post':
            $result = person_postPerson($POST_DATA);

            if(!$POST_ERROR) {
                $POST_ID = $result['id'];
                $POST_HASH = $result['hash'];
                $resultNickname = $result['nickname'];

                if($POST_USER) {
                    user_savePerson($POST_USER, $POST_ID, $POST_HASH);
                }

                cookiePerson($resultNickname, $POST_ID, $POST_HASH);
            }
            break;

        case 'person--put':
            person_putPerson($POST_DATA, $POST_HASH);

            if(!$POST_ERROR) {
                if(isset($POST_DATA['background_id'])) {
                    person_putAttributeFromTable('background', $POST_DATA['background_id'], $POST_ID);
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
            }
            break;

        case 'person--augmentation':
            person_postAugmentation($POST_DATA, $POST_ID);
            break;

        case 'person--bionic':
            person_postBionic($POST_DATA, $POST_ID);
            break;

        case 'person--edit--attribute':
            person_postAttribute($POST_DATA, $POST_ID, true);
            break;

        case 'person--edit--feature':
            if(isset($POST_DATA['species_id'])) {
                person_putPerson(['species_id' => $POST_DATA['species_id']], $POST_HASH);
                person_putAttributeFromTable('species-attribute', $POST_DATA['species_id'], $POST_ID, $POST_DATA['current_id']);
            }

            if(isset($POST_DATA['background_id'])) {
                person_putPerson(['background_id' => $POST_DATA['background_id']], $POST_HASH);
                person_putAttributeFromTable('background', $POST_DATA['background_id'], $POST_ID, $POST_DATA['current_id']);
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

        case 'person--equip':
            $post = ['equipped' => $POST_DATA['value']];
            person_putTable($POST_DATA['table'], $POST_ID, $POST_DATA['id'], $post);
            break;

        case 'person--expertise':
            person_postExpertise($POST_DATA, $POST_ID);

            if(!$POST_ERROR) {
                person_putPerson(['point_expertise' => 0], $POST_HASH);

                if(isset($_POST['post--experience'])) {
                    $key = 'attribute_id__'.$_POST['post--experience'];
                    $value = intval($_POST['post--points']);

                    person_postAttribute([$key => $value], $POST_ID, true);
                }
            }
            break;

        case 'person--milestone':
            $post = ['person_id' => $POST_ID, 'milestone_id' => $POST_DATA['milestone']];
            person_postTo('milestone', $post);

            if(!$POST_ERROR) {
                person_putAttributeFromTable('milestone', $POST_DATA['milestone'], $POST_ID);

                $calc = intval($_POST['post--points']) - 1;
                person_putPerson(['point_milestone' => $calc], $POST_HASH);
            }
            break;

        case 'person--gift':
            $post = ['person_id' => $POST_ID, 'characteristic_id' => $POST_DATA['characteristic']];
            person_postTo('characteristic', $post);

            if(!$POST_ERROR) {
                person_putAttributeFromTable('characteristic', $POST_DATA['characteristic'], $POST_ID);

                if(!$POST_ERROR) {
                    $calc = intval($_POST['post--points']) - 1;
                    person_putPerson(['point_characteristic_gift' => $calc], $POST_HASH);
                }
            }
            break;

        case 'person--imperfection':
            $post = ['person_id' => $POST_ID, 'characteristic_id' => $POST_DATA['characteristic']];
            person_postTo('characteristic', $post);

            if(!$POST_ERROR) {
                person_putAttributeFromTable('characteristic', $POST_DATA['characteristic'], $POST_ID);

                if(!$POST_ERROR) {
                    $calc = intval($_POST['post--points']) - 1;
                    person_putPerson(['point_characteristic_imperfection' => $calc], $POST_HASH);
                }
            }
            break;

        case 'person--money':
            person_putAttribute($POST_ID, $POST_DATA['attribute_id'], $POST_DATA['value']);

            if(!$POST_ERROR) {
                person_putPerson(['point_money' => 0], $POST_HASH);
            }
            break;

        case 'person--protection':
            person_postProtection($POST_DATA, $POST_ID);
            break;

        case 'person--skill':
            person_postAttribute($POST_DATA, $POST_ID);

            if(!$POST_ERROR) {
                person_putPerson(['point_skill' => 0], $POST_HASH);

                if(!$POST_ERROR) {
                    if(isset($_POST['post--experience'])) {
                        $key = 'attribute_id__'.$_POST['post--experience'];
                        $value = intval($_POST['post--points']);

                        person_postAttribute([$key => $value], $POST_ID, true);
                    }
                }
            }
            break;

        case 'person--supernatural':
            person_postAttribute($POST_DATA, $POST_ID);

            if(!$POST_ERROR) {
                person_putPerson(['point_supernatural' => 0], $POST_HASH);

                if(!$POST_ERROR) {
                    if(isset($_POST['post--experience'])) {
                        $key = 'attribute_id__'.$_POST['post--experience'];
                        $value = intval($_POST['post--points']);

                        person_postAttribute([$key => $value], $POST_ID, true);
                    }
                }
            }
            break;

        case 'person--supernatural--power':
            person_putAttribute($POST_ID, $POST_DATA['attribute_id'], $POST_DATA['value']);

            if(!$POST_ERROR) {
                person_putPerson(['point_power' => 0], $POST_HASH);
            }
            break;

        case 'person--supernatural--expertise':
            $post = [$POST_DATA['expertise_id'] => 1];
            person_postExpertise($post, $POST_ID);
            break;

        case 'person--weapon':
            person_postWeapon($POST_DATA, $POST_ID);

            if(!$POST_ERROR) {
                person_putPerson(['calculated' => 1], $POST_HASH);
            }
            break;

        case 'person--remove--thing':
            person_removeFrom($POST_DATA['table'], $POST_DATA['id'], $POST_ID);
            break;

        case 'person--wound--add':
            $return = world_woundAdd($POST_DATA);
            person_woundAdd($POST_DATA, $POST_ID, $return['id']);
            break;

        case 'person--wound--aid':
            $post = ['aid' => $POST_DATA['value']];
            person_putTable('wound', $POST_ID, $POST_DATA['id'], $post);
            break;

        case 'person--wound--heal':
            $post = ['heal' => $POST_DATA['value']];
            person_putTable('wound', $POST_ID, $POST_DATA['id'], $post);
            break;
    }
}