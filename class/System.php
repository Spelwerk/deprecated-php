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
            $this->makeWorldSelect();

        } else if(!isset($person) && isset($world) && !isset($species)) {
            echo '<h2>Select Species</h2>';
            $this->makeSpeciesSelect($world);

        } else if(!isset($person) && isset($world) && isset($species)) {
            echo '<h2>Required Information</h2>';
            $this->makePerson($world, $species);

        } else if(isset($person)) {
            if($person->pointMoney > 0) {
                $this->makeAttribute(
                    $person,
                    $person->world->money,
                    $person->pointMoney,
                    'dice',
                    'money'
                );

            } else if($person->isSupernatural && !isset($person->manifestation)) {
                $this->makeSelect(
                    $person,
                    $this->getManifestationList($person),
                    'manifestation_id'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && !isset($person->focus)) {
                $this->makeSelect(
                    $person,
                    $this->getFocusList($person),
                    'focus_id',
                    'Focus'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && isset($person->focus) && $person->getExpertise($person->manifestation->expertiseType) == null) {
                $this->makeSelect(
                    $person,
                    $this->getSupernaturalExpertiseList($person),
                    'expertise_id',
                    null,
                    'supernatural--expertise'
                );

            } else if($person->isSupernatural && $person->pointPower > 0) {
                $this->makeAttribute(
                    $person,
                    $person->manifestation->power,
                    $person->pointPower,
                    'dice',
                    'supernatural--power'
                );

            } else if(!isset($person->caste)) {
                $this->makeSelect(
                    $person,
                    $this->getCasteList($person),
                    'caste_id',
                    'Caste'
                );

            } else if(!isset($person->nature)) {
                $this->makeSelect(
                    $person,
                    $this->getNatureList($person),
                    'nature_id',
                    'Nature'
                );

            } else if(!isset($person->identity)) {
                $this->makeSelect(
                    $person,
                    $this->getIdentityList($person),
                    'identity_id',
                    'Identity'
                );

            } else if($person->pointGift > 0) {
                $this->makeCharacteristicSelect($person, 1, $person->pointGift);

            } else if($person->pointImperfection > 0) {
                $this->makeCharacteristicSelect($person, 0, $person->pointImperfection);

            } else if($person->pointUpbringing > 0) {
                $this->makeMilestoneSelect($person, 1, $person->pointUpbringing);

            } else if($person->pointMilestone > 0) {
                $this->makeMilestoneSelect($person, 0, $person->pointMilestone);

            } else if($person->pointSkill > 0) {
                $this->makeSkillPurchase($person, $person->pointSkill);

            } else if($person->pointExpertise > 0) {
                $this->makeExpertisePurchase($person, $person->pointExpertise);

            } else if($person->isSupernatural && $person->pointSupernatural > 0) {
                $this->makeSupernaturalPurchase($person, $person->pointSupernatural);

            } else if(!isset($person->firstname) || !isset($person->surname) || !isset($person->gender)) {
                $this->makePersonDescription($person);

            } else if($person->canWeapon() == 0) {
                $this->makeWeaponSelect($person);

            }
        }
    }


    function getWorldList() {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world/template')['data'];

        foreach ($data as $array) {
            $arrayList[] = new World(null, null, $array);
        }

        return $arrayList;
    }

    function getSpeciesList($worldId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-species/id/'.$worldId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Species(null, $array);
        }

        return $arrayList;
    }

    function getManifestationList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-manifestation/id/'.$person->world->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Manifestation(null, $array);
        }

        return $arrayList;
    }

    function getFocusList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-focus/id/'.$person->world->id.'/manifestation/'.$person->manifestation->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Focus(null, $array);
        }

        return $arrayList;
    }

    function getCasteList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-caste/id/'.$person->world->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Caste(null, $array);
        }

        return $arrayList;
    }

    function getNatureList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-nature/id/'.$person->world->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Nature(null, $array);
        }

        return $arrayList;
    }

    function getIdentityList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-identity/id/'.$person->world->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Identity(null, $array);
        }

        return $arrayList;
    }

    function getCharacteristicList($person, $gift) {
        global $curl;

        $idList = [];
        $arrayList = [];

        $current = $curl->get('person-characteristic/id/'.$person->id.'/gift/'.$gift);

        $currentList = isset($current['data'])
            ? $current['data']
            : null;

        if($currentList) {
            foreach($currentList as $item) {
                $idList[] = $item['id'];
            }
        }

        $get = isset($person->manifestation->id)
            ? 'world-characteristic/id/'.$person->world->id.'/gift/'.$gift.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id
            : 'world-characteristic/id/'.$person->world->id.'/gift/'.$gift.'/species/'.$person->species->id;

        $data = $curl->get($get)['data'];

        foreach ($data as $array) {
            if(!in_array($array['id'],$idList)) {
                $arrayList[] = new Characteristic(null, $array);
            }
        }

        return $arrayList;
    }

    function getMilestoneList($person, $upbringing) {
        global $curl;

        $idList = [];
        $arrayList = [];

        $current = $curl->get('person-milestone/id/'.$person->id.'/upbringing/'.$upbringing);

        $currentList = isset($current['data'])
            ? $current['data']
            : null;

        if($currentList) {
            foreach($currentList as $item) {
                $idList[] = $item['id'];
            }
        }

        $get = isset($person->manifestation->id)
            ? 'world-milestone/id/'.$person->world->id.'/upbringing/'.$upbringing.'/caste/'.$person->caste->id.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id
            : 'world-milestone/id/'.$person->world->id.'/upbringing/'.$upbringing.'/caste/'.$person->caste->id.'/species/'.$person->species->id;

        $data = $curl->get($get)['data'];

        foreach ($data as $array) {
            if(!in_array($array['id'],$idList)) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    function getExpertiseList($person, $skill, $type) {
        global $curl;

        $arrayList = [];
        $returnList = null;

        $get = isset($person->manifestation->id)
            ? 'world-expertise/id/'.$person->world->id.'/skill/'.$skill.'/type/'.$type.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id
            : 'world-expertise/id/'.$person->world->id.'/skill/'.$skill.'/type/'.$type.'/species/'.$person->species->id;

        $result = $curl->get($get);

        $data = isset($result['data'])
            ? $result['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Expertise(null, $array);
            }

            $returnList = $arrayList;
        }

        return $returnList;
    }

    function getSupernaturalExpertiseList($person) {
        global $curl;

        $arrayList = [];
        $returnList = null;

        $result = $curl->get('world-expertise/id/'.$person->world->id.'/type/'.$person->manifestation->expertiseType);

        $data = isset($result['data'])
            ? $result['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Expertise(null, $array);
            }

            $returnList = $arrayList;
        }

        return $returnList;
    }

    function getSupernaturalList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-attribute/id/'.$person->world->id.'/type/'.$person->manifestation->attributeType.'/species/'.$person->species->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Attribute(null, $array);
        }

        return $arrayList;
    }

    function getWeaponList($person, $group) {
        global $curl;

        $arrayList = [];
        $returnList = null;

        $result = $curl->get('world-weapon/id/'.$person->world->id.'/group/'.$group);

        $data = isset($result['data'])
            ? $result['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Weapon(null, $array);
            }

            $returnList = $arrayList;
        }

        return $returnList;
    }


    function makeWorldSelect() {
        global $form;

        $list = $this->getWorldList();

        $form->genericStart('play');
        $form->genericSelect('person', 'world_id', $list);
        $form->genericEnd();
    }

    function makeSpeciesSelect($world) {
        global $form;

        $list = $this->getSpeciesList($world->id);

        $form->genericStart('play');
        $form->genericSelect('person', 'species_id', $list);
        $form->getHidden('person', 'world_id', $world->id);
        $form->genericEnd();
    }

    function makePerson($world, $species) {
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


    public function makeAttribute($person, $attributeId, $points, $pointsText, $postDo) {
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

    public function makeSelect($person, $list, $listTableName, $withRoll = null, $do = null, $value = null) {
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


    public function makeCharacteristicSelect($person, $gift, $points = null) {
        global $form;

        $list = $this->getCharacteristicList($person, $gift);

        $text = $gift == 1
            ? 'gift'
            : 'imperfection';

        $form->genericStart();

        $form->pointsForm($points, $text);
        $form->rollRadio('Characteristic');
        $form->viewStart();

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$text);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        foreach($list as $characteristic) {
            $form->getRadio('person', 'characteristic_id', $characteristic->name, $characteristic->id, $characteristic->description);
        }

        $form->getHidden('person', 'person_id', $person->id);

        $form->viewEnd();
        $form->genericEnd();
    }

    public function makeMilestoneSelect($person, $upbringing, $points) {
        global $form;

        $list = $this->getMilestoneList($person, $upbringing);

        $text = $upbringing == 1
            ? 'upbringing'
            : 'flexible';

        $form->genericStart();
        $form->pointsForm($points, $text);

        $form->rollRadio('Milestone');
        $form->viewStart();

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--'.$text);
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        foreach($list as $milestone) {
            $form->getRadio('person', 'milestone_id', $milestone->name, $milestone->id, $milestone->description);
        }

        $form->getHidden('person', 'person_id', $person->id);

        $form->viewEnd();
        $form->genericEnd();
    }


    public function makeSkillPurchase($person, $points) {
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

    public function makeExpertisePurchase($person, $points) {
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
                    $expertiseList = $this->getExpertiseList($person, $skill->id, $type['id']);

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

    public function makeSupernaturalPurchase($person, $points) {
        global $curl, $form;

        $supernaturalList = $this->getSupernaturalList($person);
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


    public function makePersonDescription($person) {
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


    public function makeWeaponSelect($person) {
        global $form, $curl;

        $groupList = $curl->get('weapongroup')['data'];
        $currentList = $person->getWeapon();
        $speciesList = $person->species->getWeapon();
        $expertiseList = $person->getExpertise();
        $idList = [];

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--weapon');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        if(count($currentList) != null) {
            foreach ($currentList as $current) {
                $idList[] = $current->id;
            }
        }

        foreach($groupList as $group) {
            $weaponList = $this->getWeaponList($person, $group['id']);

            if(isset($weaponList)) {
                foreach($weaponList as $weapon) {
                    if(!in_array($weapon->id, $idList)) {
                        $form->getCheckbox('weapon', $weapon->name, $weapon->id, $weapon->description);
                    }
                }
            }
        }

        foreach($speciesList as $species) {
            $form->getHidden('weapon', $species['weapon_id'], 0);
        }

        foreach($expertiseList as $expertise) {
            if($expertise->weapon != 0) {
                $form->getHidden('weapon', $expertise-$weapon, 0);
            }
        }

        $form->genericEnd();
    }
}