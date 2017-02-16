<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-23
 * Time: 14:14
 */
class System {
    public function __construct() {}


    public function createPerson($person = null, $world = null, $species = null) {
        if(!isset($person) && !isset($world) && !isset($species)) {
            echo '<h2>Select World</h2>';

            $this->person_selectWorld();

        } else if(!isset($person) && isset($world) && !isset($species)) {
            echo '<h2>Select Species</h2>';

            $this->person_selectSpecies($world);

        } else if(!isset($person) && isset($world) && isset($species)) {
            echo '<h2>Required Information</h2>';

            $this->person_make($world, $species);

        } else if(isset($person)) {
            if($person->pointMoney > 0) {
                echo '<h2>Money</h2>';

                $this->person_rollAttribute(
                    $person,
                    $person->world->money,
                    $person->pointMoney,
                    'dice',
                    'money'
                );

            } else if($person->isSupernatural && !isset($person->manifestation)) {
                echo '<h2>Manifestation</h2>';

                $this->person_select(
                    $person,
                    $person->world->getManifestation(),
                    'manifestation_id'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && !isset($person->focus)) {
                echo '<h2>Focus</h2>';

                $this->person_select(
                    $person,
                    $person->world->getFocus($person->manifestation->id),
                    'focus_id'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && isset($person->focus) && $person->getExpertise($person->manifestation->expertiseType) == null) {
                echo '<h2>Supernatural Expertise</h2>';

                $this->person_select(
                    $person,
                    $person->world->getExpertise($person->manifestation->expertiseType),
                    'expertise_id',
                    null,
                    'supernatural--expertise'
                );

            } else if($person->isSupernatural && $person->pointPower > 0) {
                echo '<h2>Potential</h2>';

                $this->person_rollAttribute(
                    $person,
                    $person->manifestation->power,
                    $person->pointPower,
                    'dice',
                    'supernatural--power'
                );

            } else if(!isset($person->caste)) {
                echo '<h2>Caste</h2>';

                $this->person_select(
                    $person,
                    $person->world->getCaste(),
                    'caste_id',
                    'Caste'
                );

            } else if(!isset($person->nature)) {
                echo '<h2>Nature</h2>';

                $this->person_select(
                    $person,
                    $person->world->getNature(),
                    'nature_id',
                    'Nature'
                );

            } else if(!isset($person->identity)) {
                echo '<h2>Identity</h2>';

                $this->person_select(
                    $person,
                    $person->world->getIdentity(),
                    'identity_id',
                    'Identity'
                );

            } else if($person->pointGift > 0) {
                echo '<h2>Characteristic</h2>';

                $this->person_selectCharacteristic($person, 1, $person->pointGift);

            } else if($person->pointImperfection > 0) {
                echo '<h2>Characteristic</h2>';

                $this->person_selectCharacteristic($person, 0, $person->pointImperfection);

            } else if($person->pointUpbringing > 0) {
                echo '<h2>Milestone</h2>';

                $this->person_selectMilestone($person, 1, $person->pointUpbringing);

            } else if($person->pointMilestone > 0) {
                echo '<h2>Milestone</h2>';

                $this->person_selectMilestone($person, 0, $person->pointMilestone);

            } else if($person->pointSkill > 0) {
                echo '<h2>Skill</h2>';

                $this->person_purchaseSkill($person, $person->pointSkill);

            } else if($person->pointExpertise > 0) {
                echo '<h2>Expertise</h2>';

                $this->person_purchaseExpertise($person, $person->pointExpertise);

            } else if($person->isSupernatural && $person->pointSupernatural > 0) {
                echo '<h2>'.$person->manifestation->name.'</h2>';

                $this->person_purchaseSupernatural($person, $person->pointSupernatural);

            } else if(!isset($person->firstname) || !isset($person->surname) || !isset($person->gender)) {
                echo '<h2>Further Information</h2>';

                $this->person_describe($person);

            } else {
                echo '<h2>Weapon</h2>';

                $this->person_checkWeapon($person);

            }
        }
    }

    function getWorld() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world/template');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new World(null, null, $array);
            }
        }

        return $arrayList;
    }


    function idList($list) {
        $idList = null;

        if(count($list) != null) {
            foreach($list as $item) {
                $idList[] = $item->id;
            }
        }

        return $idList;
    }

    function checkboxList($itemList, $idList = null, $checkboxName) {
        global $form;

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $form->getCheckbox($checkboxName, $item->name, $item->id, $item->description);
                }
            }
        }
    }

    function radioList($itemList, $idList = null, $radioName, $radioSelect) {
        global $form;

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $form->getRadio($radioName, $radioSelect, $item->name, $item->id, $item->description);
                }
            }
        }
    }


    function person_selectWorld() {
        global $form;

        $list = $this->getWorld();

        $form->genericStart('play');

        $form->genericSelect('person', 'world_id', $list);

        $form->genericEnd();
    }

    function person_selectSpecies($world) {
        global $form;

        $list = $world->getSpecies();

        $form->genericStart('play');

        $form->genericSelect('person', 'species_id', $list);

        $form->getHidden('person', 'world_id', $world->id);

        $form->genericEnd();
    }

    function person_make($world, $species) {
        global $form, $user;

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--post');

        if(isset($user->id)) {
            $form->getHidden('post', 'user', $user->id);
        }

        $form->getVarchar('person', 'nickname', true);
        $form->getNumber('person', 'age', true, 5, $species->maxAge);
        $form->getVarchar('person', 'occupation', true);

        if($world->existsSupernatural) {
            $form->getBool('person', 'supernatural', true);
        } else {
            $form->getHidden('person', 'supernatural', 0);
        }

        $form->getHidden('person', 'world_id', $world->id);
        $form->getHidden('person', 'species_id', $species->id);
        $form->getHidden('person', 'cheated', 0);
        $form->getHidden('person', 'template', 0);
        $form->getHidden('person', 'popularity', 0);
        $form->getHidden('person', 'calculated', 0);
        $form->genericEnd();
    }

    function person_describe($person) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        $form->getVarchar('person', 'firstname', true);
        $form->getVarchar('person', 'surname', true);
        $form->getVarchar('person', 'gender', true);

        $form->getText('person', 'description', false);
        $form->getText('person', 'behaviour', false);
        $form->getText('person', 'appearance', false);
        $form->getText('person', 'features', false);
        $form->getText('person', 'personality', false);
        $form->genericEnd();
    }


    public function person_rollAttribute($person, $attributeId, $points, $pointsText, $postDo) {
        global $curl, $form;

        $attribute = $curl->get('attribute/id/'.$attributeId)['data'][0];

        $form->genericStart();

        $form->pointsForm($points, $pointsText);
        $form->rollNumber($attribute['name'], $points);

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$postDo);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        $form->viewStart();
        $form->getNumber('person', 'value', true, null, $attribute['maximum']);
        $form->viewEnd();

        $form->getHidden('person', 'attribute_id', $attribute['id']);

        $form->genericEnd();
    }


    public function person_select($person, $list, $listTableName, $withRoll = null, $do = null, $value = null) {
        global $form;

        $do = isset($do)
            ? $do
            : 'put';

        $form->genericStart();

        if(isset($withRoll)) {
            $form->rollRadio($withRoll);
            $form->viewStart();
        }

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$do);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', $listTableName, $list, $value);

        if(isset($withRoll)) $form->viewEnd();

        $form->genericEnd();
    }

    public function person_selectCharacteristic($person, $gift, $points = null) {
        global $form;

        $list = null;

        if($person->isSupernatural) {
            $list = $person->world->getCharacteristic($gift, $person->species->id, $person->manifestation->id);
        } else {
            $list = $person->world->getCharacteristic($gift, $person->species->id);
        }

        $idList = $this->idList($person->getCharacteristic());

        $text = $gift == 1
            ? 'gift'
            : 'imperfection';

        $form->genericStart();

        $form->pointsForm($points, $text);
        $form->rollRadio('characteristic');
        $form->viewStart();

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$text);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        $this->radioList($list, $idList, 'person', 'characteristic');

        $form->viewEnd();
        $form->genericEnd();
    }

    public function person_selectMilestone($person, $upbringing, $points) {
        global $form;

        $list = null;

        if($person->isSupernatural) {
            $list = $person->world->getMilestone($upbringing, $person->caste->id, $person->species->id, $person->manifestation->id);
        } else {
            $list = $person->world->getMilestone($upbringing, $person->caste->id, $person->species->id);
        }


        $idList = $this->idList($person->getMilestone());

        $text = $upbringing == 1
            ? 'upbringing'
            : 'flexible';

        $form->genericStart();

        $form->pointsForm($points, $text);
        $form->rollRadio('milestone');
        $form->viewStart();

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$text);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        $this->radioList($list, $idList, 'person', 'milestone');

        $form->viewEnd();
        $form->genericEnd();
    }


    public function person_purchaseExpertise($person, $points) {
        global $form, $curl;

        $typeList = $curl->get('expertisetype')['data'];
        $skillList = $person->getAttribute($person->world->attributeSkill);
        $currentList = $person->getExpertise();
        $idList = [];

        $form->genericStart();

        $form->pointsForm($points, 'points');

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--expertise');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        if($points == 999) {
            $form->getHidden('post', 'points', 999);
        }

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $skillVal = 0;

                foreach($skillList as $skill) {
                    if($skill->id == $current->skill['id']) {
                        $skillVal = $skill->value;
                    }
                }

                $math1 = $skillVal - $current->skill['required'];
                $math2 = floor($math1 / $current->skill['increment']);

                $calculatedMax = $current->maximum < $math2
                    ? $current->maximum
                    : $math2 + 1;

                if($calculatedMax != 0) {
                    $form->getPurchase($current->name, $current->id, $current->description, $calculatedMax, $current->level);
                }
            }
        }

        foreach($typeList as $type) {
            foreach($skillList as $skill) {
                if($skill->value >= $type['skill_attribute_required']) {
                    $expertiseList = $person->world->getExpertise($type['id'], $skill->id, $person->species->id);

                    $math1 = $skill->value - $type['skill_attribute_required'];
                    $math2 = floor($math1 / $type['skill_attribute_increment']);

                    if(isset($expertiseList)) {
                        foreach($expertiseList as $expertise) {
                            if(!in_array($expertise->id, $idList)) {
                                $calculatedMax = $expertise->maximum < $math2
                                    ? $expertise->maximum
                                    : $math2 + 1;

                                $form->getPurchase($expertise->name, $expertise->id, $expertise->description, $calculatedMax);
                            }
                        }
                    }
                }
            }
        }

        $form->genericEnd();
    }

    public function person_purchaseSkill($person, $points) {
        global $form;

        $currentList = $person->getAttribute($person->world->attributeSkill);

        $form->genericStart();
        $form->pointsForm($points, 'points');

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--skill');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        if($points == 999) {
            $form->getHidden('post', 'points', 999);
        }

        foreach($currentList as $current) {
            $form->getPurchase($current->name, $current->id, $current->description, $current->maximum, $current->value);
        }

        $form->genericEnd();
    }

    public function person_purchaseSupernatural($person, $points) {
        global $curl, $form;

        $supernaturalList = $person->world->getAttribute($person->manifestation->attributeType, $person->species->id);
        $expertiseList = $person->getExpertise();
        $currentList = $person->getAttribute($person->manifestation->attributeType);
        $idList = [];
        $expList = [];

        $personPower = $curl->get('person-attribute/id/'.$person->id.'/attribute/'.$person->manifestation->power)['data'][0]['value'];

        $form->genericStart();
        $form->pointsForm($points, 'points');

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--supernatural');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        if($points == 999) {
            $form->getHidden('post', 'points', 999);
        }

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $maximum = $personPower > $current->maximum
                    ? $current->maximum
                    : $personPower;

                $form->getPurchase($current->name, $current->id, $current->description, $maximum, $current->value);
            }
        }

        foreach($expertiseList as $expertise) {
            $expList[] = $expertise->attribute['id'];
        }

        foreach($supernaturalList as $supernatural) {
            if(in_array($supernatural->id, $expList) && !in_array($supernatural->id, $idList)) {

                $maximum = $personPower > $supernatural->maximum
                    ? $current->maximum
                    : $personPower;

                $form->getPurchase($supernatural->name, $supernatural->id, $supernatural->description, $maximum);
            }
        }

        $form->genericEnd();
    }


    public function person_checkAugmentation($person) {
        global $form;

        $bionicList = $person->getBionic();
        $idList = $this->idList($person->getAugmentation());

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--augmentation');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        if(isset($bionicList)) {
            foreach($bionicList as $bionic) {
                $augmentationList = $person->world->getAugmentation($bionic->id);

                echo('<h4>'.$bionic->name.'</h4>');

                $this->checkboxList($augmentationList, $idList, 'augmentation');
            }
        }


        $form->genericEnd();
    }

    public function person_checkBionic($person) {
        global $form, $curl;

        $bodypartList = $curl->get('bodypart')['data'];

        $idList = $this->idList($person->getBionic());

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--bionic');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        foreach($bodypartList as $bodypart) {
            $bionicList = $person->world->getBionic($bodypart['id']);

            echo('<h4>'.$bodypart['name'].'</h4>');

            $this->checkboxList($bionicList, $idList, 'bionic');
        }

        $form->genericEnd();
    }

    public function person_checkProtection($person) {
        global $form, $curl;

        $typeList = $curl->get('protectiontype')['data'];

        $idList = $this->idList($person->getProtection());

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--protection');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        foreach($typeList as $type) {
            $protectionList = $person->world->getProtection($type['id']);

            echo('<h4>'.$type['name'].'</h4>');

            $this->checkboxList($protectionList, $idList, 'bionic');
        }

        $form->genericEnd();
    }

    public function person_checkWeapon($person) {
        global $form, $curl;

        $groupList = $curl->get('weapongroup')['data'];
        $speciesList = $person->species->getWeapon();

        $idList = $this->idList($person->getWeapon());

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--weapon');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        foreach($groupList as $group) {
            $weaponList = $person->world->getWeapon($group['id']);

            $this->checkboxList($weaponList, $idList, 'weapon');
        }

        if(isset($speciesList)) {
            foreach($speciesList as $species) {
                $form->getHidden('weapon', $species['weapon_id'], 0);
            }
        }

        $form->genericEnd();
    }
}