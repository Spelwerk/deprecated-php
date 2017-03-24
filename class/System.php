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

                $exp = $person->getAttribute(null, $person->world->experience)[0];
                $pts = $person->pointExpertise;

                $this->person_purchaseExpertise($person, intval($exp->value + $pts));

            } else if($person->isSupernatural && $person->pointSupernatural > 0) {
                echo '<h2>'.$person->manifestation->name.'</h2>';

                $exp = $person->getAttribute(null, $person->world->experience)[0];
                $pts = $person->pointSupernatural;

                $this->person_purchaseDiscipline($person, intval($exp->value + $pts));

            } else if(!isset($person->firstname) || !isset($person->surname) || !isset($person->gender)) {
                echo '<h2>Further Information</h2>';

                $this->person_describe($person);

            } else {
                echo '<h2>Weapon</h2>';

                $this->person_checkWeapon($person);

            }
        }
    }

    public function createWorld($world = null) {
        if(!isset($world)) {
            echo('<h2>Create World</h2>');
            $this->world_make();

        } else {
            if($world->splitSupernatural == 0 && $world->splitSkill == 0 && $world->splitExpertise == 0 && $world->splitMilestone == 0 && $world->splitRelationship == 0) {
                echo(
                    '<h2>Manage Age Split</h2>'.
                    '<p>When creating a new person, some features are calculated based on: [age/world_modifier]. It is time to set this modifier. We have given you example values from our usual worlds.</p>'
                );
                $this->world_makeSplit($world);

            } else if($world->maxGift == 0 && $world->maxImperfection == 0 && $world->maxSupernatural == 0 && $world->maxSkill == 0 && $world->maxExpertise == 0 && $world->maxUpbringing == 0 && $world->maxFlexible == 0 && $world->maxRelationship == 0) {
                echo(
                    '<h2>Manage Maximum</h2>'.
                    '<p>After calculating the agesplit, we also take into account that you may want to set a maximum value. It is time to set this value. We have given you example values from our usual worlds. There are hard limitations here for data weight purposes.</p>'
                );
                $this->world_makeMaximum($world);

            } else if(count($world->getSpecies()) == 0) {
                echo(
                    '<h2>Species</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'species');

            } else if(count($world->getCaste()) == 0) {
                echo(
                    '<h2>Caste</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'caste');

            } else if(count($world->getNature()) == 0) {
                echo(
                    '<h2>Nature</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'nature');

            } else if(count($world->getIdentity()) == 0) {
                echo(
                    '<h2>Identity</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'identity');

            } else if(count($world->getAttribute()) == 0) {
                echo(
                    '<h2>Defaults</h2>'.
                    '<p></p>'
                );
                $this->world_makeDefaultAttribute($world);

            } else if(count($world->getAttribute($world->attributeSkill)) == 0) {
                echo(
                    '<h2>Skills</h2>'.
                    '<p></p>'
                );
                $this->world_checkSkill($world);

            } else if(count($world->getExpertise($world->expertiseAttribute)) == 0) {
                echo(
                    '<h2>Attribute Expertise</h2>'.
                    '<p></p>'
                );
                $this->world_checkExpertise($world, $world->expertiseAttribute);

            } else if(count($world->getExpertise($world->expertiseDice)) == 0) {
                echo(
                    '<h2>Dice Expertise</h2>'.
                    '<p></p>'
                );
                $this->world_checkExpertise($world, $world->expertiseDice);

            } else if($world->existsSupernatural && $world->supernaturalName == null) {
                echo(
                    '<h2>Supernatural Name</h2>'.
                    '<p>What is the formal name of supernatural people in your world?</p>'
                );
                $this->world_makeSupernaturalName($world);

            } else if($world->existsSupernatural && count($world->getManifestation()) == 0) {
                echo(
                    '<h2>Manifestation</h2>'.
                    '<p></p>'
                );
                $this->world_checkManifestation($world, 'manifestation');

            } else if(count($world->getCharacteristic(1)) == 0) {
                echo(
                    '<h2>Gift</h2>'.
                    '<p></p>'
                );
                $this->world_checkCharacteristic($world, 1);

            } else if(count($world->getCharacteristic(0)) == 0) {
                echo(
                    '<h2>Imperfection</h2>'.
                    '<p></p>'
                );
                $this->world_checkCharacteristic($world, 0);

            } else if(count($world->getMilestone(1)) == 0) {
                echo(
                    '<h2>Upbringing</h2>'.
                    '<p></p>'
                );
                $this->world_checkMilestone($world, 1);

            } else if(count($world->getMilestone(0)) == 0) {
                echo(
                    '<h2>Flexible</h2>'.
                    '<p></p>'
                );
                $this->world_checkMilestone($world, 0);

            } else if(count($world->getWeapon()) == 0) {
                echo(
                    '<h2>Weapon</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'weapon');

            } else if(count($world->getProtection()) == 0) {
                echo(
                    '<h2>Protection</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'protection');

            } else if($world->existsBionic && count($world->getBionic()) == 0) {
                echo(
                    '<h2>Bionic</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'bionic');

            } else if($world->existsAugmentation && count($world->getAugmentation()) == 0) {
                echo(
                    '<h2>Augmentation</h2>'.
                    '<p></p>'
                );
                $this->world_checkAugmentation($world);

            }
        }
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

    function checkboxAll() {
        echo(
            '<label for="post--checkAll">'.
            '<div class="sw-c-radio__item sw-js-check-item">'.
            '<div class="sw-c-radio__header">'.
            '<div class="sw-c-radio__radio">'.
            '<img class="sw-js-check-false" src="/img/checkbox-false.png"/>'.
            '<img class="sw-js-check-true sw-is-hidden" src="/img/checkbox-true.png"/>'.
            '</div>'.
            '<div class="sw-c-radio__title sw-js-check-title">Check All</div>'.
            '</div>'.
            '<input class="sw-js-check-all sw-is-hidden" type="checkbox" name="post--checkAll" id="post--checkAll" value="0"/>'.
            '</div>'.
            '</label>'
        );
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
        global $form, $curl, $user;

        $list = null;

        if($user) {
            $userList = $curl->get('user-world/id/'.$user->id.'/calculated');

            if(isset($userList['data'])) {
                foreach($userList['data'] as $item) {
                    $list[] = new World($item['world_id']);
                }
            }
        }

        $worldList = $curl->get('world/template')['data'];

        foreach($worldList as $item) {
            $list[] = new World(null, null, $item);
        }

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
        $form->hidden('experience', $person->world->experience, 'post');

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

        $form->hidden('return', 'play', 'post');
        $form->hidden('do', 'person--skill', 'post');
        $form->hidden('id', $person->id, 'post');
        $form->hidden('hash', $person->hash, 'post');
        $form->hidden('experience', $person->world->experience, 'post');

        if($points == 999) {
            $form->getHidden('post', 'points', 999);
        }

        foreach($currentList as $current) {
            $form->purchase('attribute_id', $current->name, $current->description, $current->id, 0, $current->maximum, $current->value);
        }

        $form->genericEnd();
    }

    public function person_purchaseDiscipline($person, $points) {
        global $curl, $form;

        $supernaturalList = $person->world->getAttribute($person->manifestation->disciplineAttributeType, $person->species->id);
        $expertiseList = $person->getExpertise();
        $currentList = $person->getAttribute($person->manifestation->disciplineAttributeType);
        $idList = [];
        $expList = [];

        $personPower = $curl->get('person-attribute/id/'.$person->id.'/attribute/'.$person->manifestation->power)['data'][0]['value'];

        $form->genericStart();
        $form->pointsForm($points, 'points');

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--supernatural');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);
        $form->hidden('experience', $person->world->experience, 'post');

        if($points == 999) {
            $form->getHidden('post', 'points', 999);
        }

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $maximum = $personPower > $current->maximum
                    ? $current->maximum
                    : $personPower;

                $form->purchase('attribute_id', $current->name, $current->description, $current->id, 0, $maximum, $current->value);
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

                $form->purchase('attribute_id', $supernatural->name, $supernatural->description, $supernatural->id, 0, $maximum);
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

        $this->checkboxAll();

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

        $this->checkboxAll();

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

        $this->checkboxAll();

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

        $this->checkboxAll();

        $form->genericEnd(false);
    }


    function world_make() {
        global $form, $curl, $user;

        //$attribute = $curl->get('attribute/type/8')['data'];
        $attributetype = $curl->get('attributetype')['data'];
        $expertisetype = $curl->get('expertisetype')['data'];

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--post');

        if(isset($user->id)) {
            $form->getHidden('post', 'user', $user->id);
        }

        $form->getVarchar('world', 'name', true);
        $form->getText('world', 'description', false);

        $form->getBool('world', 'bionic', true);
        $form->getBool('world', 'augmentation', true);
        $form->getBool('world', 'software', true);
        $form->getBool('world', 'supernatural', true);

        //$form->getDropdown('world', 'skill_attributetype_id', false, $attributetype, 10);
        $form->getHidden('world', 'skill_attributetype_id', 10);

        $form->getDropdown('world', 'attribute_expertisetype_id', false, $expertisetype, 1);
        $form->getDropdown('world', 'dice_expertisetype_id', false, $expertisetype, 2);

        //$form->getDropdown('world', 'money_attribute_id', true, $attribute);
        $form->getHidden('world', 'money_attribute_id', 19);

        $form->genericEnd();
    }

    function world_checklist($world, $thing) {
        global $form, $curl;

        $checkList = null;
        $list = $curl->get($thing)['data'];

        switch($thing)
        {
            case 'species':
                foreach($list as $item) {
                    $checkList[] = new Species(null, $item);
                }
                break;

            case 'caste':
                foreach($list as $item) {
                    $checkList[] = new Caste(null, $item);
                }
                break;

            case 'nature':
                foreach($list as $item) {
                    $checkList[] = new Nature(null, $item);
                }
                break;

            case 'identity':
                foreach($list as $item) {
                    $checkList[] = new Identity(null, $item);
                }
                break;

            case 'focus':
                foreach($list as $item) {
                    $checkList[] = new Focus(null, $item);
                }
                break;

            case 'weapon':
                foreach($list as $item) {
                    $checkList[] = new Weapon(null, $item);
                }
                break;

            case 'protection':
                foreach($list as $item) {
                    $checkList[] = new Protection(null, $item);
                }
                break;

            case 'bionic':
                foreach($list as $item) {
                    $checkList[] = new Bionic(null, $item);
                }
                break;
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', $thing);

        $this->checkboxList($checkList, null, $thing);

        $form->genericEnd(true);
    }

    function world_makeSupernaturalName($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $form->getVarchar('world', 'supernatural_name', true);

        $form->genericEnd();
    }

    function world_makeSplit($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        if($world->existsSupernatural) {
            $form->getNumber('world', 'split_supernatural', true, 1, null, 4);
        } else {
            $form->getHidden('world', 'split_supernatural', 4);
        }

        $form->getNumber('world', 'split_supernatural', true, 1, null, 4);
        $form->getNumber('world', 'split_skill', true, 1, null, 1);
        $form->getNumber('world', 'split_expertise', true, 1, null, 4);
        $form->getNumber('world', 'split_milestone', true, 1, null, 8);
        $form->getNumber('world', 'split_relationship', true, 1, null, 8);

        $form->genericEnd(false);
    }

    function world_makeMaximum($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $form->getNumber('world', 'max_characteristic_gift', true, 1, 20, 1);
        $form->getNumber('world', 'max_characteristic_imperfection', true, 1, 20, 1);

        if($world->existsSupernatural) {
            $form->getNumber('world', 'max_supernatural', true, 1, 90, 12);
        } else {
            $form->getHidden('world', 'max_supernatural', 12);
        }

        $form->getNumber('world', 'max_skill', true, 1, 90, 32);
        $form->getNumber('world', 'max_expertise', true, 1, 90, 12);
        $form->getNumber('world', 'max_milestone_upbringing', true, 1, 20, 1);
        $form->getNumber('world', 'max_milestone_flexible', true, 1, 20, 8);
        $form->getNumber('world', 'max_relationship', true, 1, 20, 8);
        $form->genericEnd(false);
    }

    public function world_makeDefaultAttribute($world) {
        global $curl, $form;

        $bodyList = $curl->get('attribute/type/1')['data'];
        $combatList = $curl->get('attribute/type/2')['data'];
        $woundList = $curl->get('attribute/type/5')['data'];

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--default');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        foreach($bodyList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 8);
        }

        foreach($combatList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 0);
        }

        foreach($woundList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 2);
        }

        $form->genericEnd(false);
    }

    public function world_checkSkill($world) {
        global $curl, $form;

        $idList = null;
        $speciesList = $world->getSpecies();
        $skillList = $curl->get('attribute/type/'.$world->attributeSkill)['data'];
        $list = null;

        foreach($speciesList as $species) {
            $idList[] = $species->id;
        }

        foreach($skillList as $skill) {
            if(in_array($skill['species_id'], $idList) || $skill['species_id'] == null) {
                $list[] = new Attribute(null, $skill);
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--skill');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($list, null, 'attribute');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkExpertise($world, $type) {
        global $curl, $form;

        $idList = null;
        $speciesList = $world->getSpecies();
        $expertiseList = $curl->get('expertise/type/'.$type)['data'];
        $list = null;

        foreach($speciesList as $species) {
            $idList[] = $species->id;
        }

        foreach($expertiseList as $item) {
            if(in_array($item['species_id'], $idList) || $item['species_id'] == null) {
                $list[] = new Expertise(null, $item);
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'expertise');

        $this->checkboxList($list, null, 'expertise');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkManifestation($world) {
        global $form, $curl;

        $checkList = null;
        $list = $curl->get('manifestation')['data'];

        foreach($list as $item) {
            $checkList[] = new Manifestation(null, $item);
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--manifestation');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($checkList, null, 'manifestation');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkCharacteristic($world, $type) {
        global $curl, $form;

        $speciesIdList = null;
        $manifestationIdList = null;

        $speciesList = $world->getSpecies();
        $manifestationList = $world->getManifestation();

        $characteristicList = $curl->get('characteristic/gift/'.$type)['data'];
        $list = null;

        foreach($speciesList as $item) {
            $speciesIdList[] = $item->id;
        }

        foreach($manifestationList as $item) {
            $manifestationIdList[] = $item->id;
        }

        foreach($characteristicList as $item) {
            if(in_array($item['species_id'], $speciesIdList) || $item['species_id'] == null) {
                if(in_array($item['manifestation_id'], $manifestationIdList) || $item['manifestation_id'] == null) {
                    $list[] = new Characteristic(null, $item);
                }
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'characteristic');

        $this->checkboxList($list, null, 'characteristic');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkMilestone($world, $type) {
        global $curl, $form;

        $speciesList = $world->getSpecies();
        $speciesIdList = null;

        $manifestationList = $world->getManifestation();
        $manifestationIdList = null;

        $attributeList = $world->getAttribute();
        $attributeIdList = null;

        $milestoneList = $curl->get('milestone/upbringing/'.$type)['data'];
        $list = null;

        foreach($speciesList as $item) {
            $speciesIdList[] = $item->id;
        }

        foreach($manifestationList as $item) {
            $manifestationIdList[] = $item->id;
        }

        foreach($attributeList as $item) {
            $attributeIdList[] = $item->id;
        }

        foreach($milestoneList as $item) {
            if(in_array($item['species_id'], $speciesIdList) || in_array($item['manifestation_id'], $manifestationIdList) || in_array($item['attribute_id'], $manifestationIdList) || $item['species_id'] == null || $item['manifestation_id'] == null || $item['attribute_id'] == null) {
                $milestone = new Milestone(null, $item);

                if(isset($milestone->casteId)) {
                    $milestone->name = $milestone->name.' ('.$milestone->casteName.')';
                }

                $list[] = $milestone;
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'milestone');

        $this->checkboxList($list, null, 'milestone');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkAugmentation($world) {
        global $curl, $form;

        $idList = null;
        $bionicList = $world->getBionic();
        $augmentationList = $curl->get('augmentation')['data'];
        $list = null;

        foreach($bionicList as $item) {
            $idList[] = $item->id;
        }

        foreach($augmentationList as $aug) {
            if(in_array($aug['bionic_id'], $idList)) {
                $augmentation = new Augmentation(null, $aug);

                $augmentation->name = $augmentation->name.' ('.$augmentation->bionicName.')';

                $list[] = $augmentation;
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--augmentation');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($list, null, 'augmentation');
        $this->checkboxAll();

        $form->genericEnd(true);
    }
}
