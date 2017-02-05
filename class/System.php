<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-23
 * Time: 14:14
 */
class System {

    var $attributetype;
    var $body, $combat, $damage, $protection, $wound, $reputation, $potential, $consumable, $experience;

    public function __construct($world = null) {

        $this->attributetype = [
            'body' => 1,
            'combat' => 2,
            'damage' => 3,
            'protection' => 4,
            'wound' => 5,
            'reputation' => 6,
            'potential' => 7,
            'consumable' => 8,
            'experience' => 9
        ];

        $this->body = [
            'tolerance' => 1,
            'stamina' => 2,
            'resilience' => 3
        ];

        $this->combat = [
            'damage' => 4,
            'initiative' => 5,
            'speed' => 6
        ];

        $this->damage = [
            'sanity' => 7,
            'exhaustion' => 8,
            'trauma' => 9
        ];

        $this->protection = [
            'ballistic' => 10,
            'bashing' => 11,
            'piercing' => 12,
            'slashing' => 13
        ];

        $this->wound = [
            'lethal' => 14,
            'serious' => 15
        ];

        $this->reputation = [
            'honor' => 16,
            'infamy' => 17
        ];

        $this->potential = [
            'potential' => 18
        ];

        $this->consumable = [
            'money' => 19,
            'ammunition' => 20,
            'rations' => 21
        ];

        $this->experience = [
            'experience' => 22
        ];

    }


    public function createPerson($person = null, $world = null, $species = null) {

        if(!isset($person) && !isset($world) && !isset($species)) {
            $this->makeWorldSelect();

        } else if(!isset($person) && isset($world) && !isset($species)) {
            $this->makeSpeciesSelect($world);

        } else if(!isset($person) && isset($world) && isset($species)) {
            $this->makePersonBasic($world, $species);

        } else if(isset($person)) {
            if($person->supernatural && !isset($person->manifestation)) {
                $this->makeManifestationSelect($person);

            } else if($person->supernatural && isset($person->manifestation) && !isset($person->focus)) {
                $this->makeFocusSelect($person);

            } else if(!isset($person->caste)) {
                $this->makeCasteSelect($person);

            } else if(!isset($person->nature)) {
                $this->makeNatureSelect($person);

            } else if(!isset($person->identity)) {
                $this->makeIdentitySelect($person);

            } else if(!isset($person->firstname) || !isset($person->surname) || !isset($person->gender)) {
                $this->makePersonDescription($person);

            } else {
                if($person->canCharacteristic(1) > 0) {
                    echo 'you have '.$person->canCharacteristic(1).' points left<br><br>';

                    $this->makeCharacteristicSelect($person, 1);

                } else if($person->canCharacteristic(0) > 0) {
                    echo 'you have '.$person->canCharacteristic(0).' points left<br><br>';

                    $this->makeCharacteristicSelect($person, 0);

                } else if($person->canMilestone(1) > 0) {
                    echo 'you have '.$person->canMilestone(1).' points left<br><br>';

                    $this->makeMilestoneSelect($person, 1);

                } else if($person->canMilestone(0) > 0) {
                    echo 'you have '.$person->canMilestone(0).' points left<br><br>';

                    $this->makeMilestoneSelect($person, 0);

                } else if($person->canSkill() > 0) {
                    echo 'you have '.$person->canSkill().' points left<br><br>';

                    $this->makeSkillPurchase($person);

                } else if($person->canExpertise() > 0) {
                    echo 'you have '.$person->canExpertise().' points left<br><br>';

                    $this->makeExpertisePurchase($person);

                } else if($person->supernatural && $person->canSupernatural() > 0) {
                    echo 'you have '.$person->canSupernatural().' points left<br><br>';

                    $this->makeSupernaturalPurchase($person);

                } else {

                }
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

        $arrayList = [];

        $get = isset($person->manifestation->id)
            ? 'world-characteristic/id/'.$person->world->id.'/gift/'.$gift.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id
            : 'world-characteristic/id/'.$person->world->id.'/gift/'.$gift.'/species/'.$person->species->id;

        $data = $curl->get($get)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Characteristic(null, $array);
        }

        return $arrayList;
    }

    function getMilestoneList($person, $upbringing) {
        global $curl;

        $arrayList = [];

        $get = isset($person->manifestation->id)
            ? 'world-milestone/id/'.$person->world->id.'/upbringing/'.$upbringing.'/caste/'.$person->caste->id.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id
            : 'world-milestone/id/'.$person->world->id.'/upbringing/'.$upbringing.'/caste/'.$person->caste->id.'/species/'.$person->species->id;

        $data = $curl->get($get)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Milestone(null, $array);
        }

        return $arrayList;
    }

    function getSkillList($person) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-attribute/id/'.$person->world->id.'/type/'.$person->world->attributeSkill.'/species/'.$person->species->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Attribute(null, $array);
        }

        return $arrayList;
    }

    function getExpertiseList($person, $skill, $type) {
        global $curl;

        $arrayList = [];

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

            return $arrayList;
        } else {
            return null;
        }
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


    public function makeWorldSelect() {
        global $form;

        $list = $this->getWorldList();

        $form->genericStart('/index.php');
        $form->genericSelect('person', 'world_id', $list);
        $form->genericEnd();
    }

    public function makeSpeciesSelect($world) {
        global $form;

        $list = $this->getSpeciesList($world->id);

        $form->genericStart('/index.php');
        $form->genericSelect('person', 'species_id', $list);
        $form->getHidden('person', 'world_id', $world->id);
        $form->genericEnd();
    }

    public function makePersonBasic($world, $species) {
        global $form;

        echo 'you have selected '.$world->name.' as world.<br>';
        echo 'you have selected '.$species->name.' as species.<br>';

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--post');

        $form->getVarchar('person', 'nickname', true);
        $form->getNumber('person', 'age', true, 5, $species->maxAge);
        $form->getVarchar('person', 'occupation', true);

        if($world->exists['supernatural']) {
            $form->getBool('person', 'supernatural', true);
        } else {
            $form->getHidden('person', 'supernatural', 0);
        }

        $form->getHidden('person', 'world_id', $world->id);
        $form->getHidden('person', 'species_id', $species->id);
        $form->getHidden('person', 'cheated', 0);
        $form->getHidden('person', 'template', 0);
        $form->getHidden('person', 'popularity', 0);
        $form->genericEnd();
    }

    public function makeManifestationSelect($person) {
        global $form;

        $list = $this->getManifestationList($person);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'manifestation_id', $list);
        $form->genericEnd();
    }

    public function makeFocusSelect($person) {
        global $form;

        $list = $this->getFocusList($person);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'focus_id', $list);
        $form->genericEnd();
    }

    public function makeCasteSelect($person) {
        global $form;

        $list = $this->getCasteList($person);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'caste_id', $list);
        $form->genericEnd();
    }

    public function makeNatureSelect($person) {
        global $form;

        $list = $this->getNatureList($person);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'nature_id', $list);
        $form->genericEnd();
    }

    public function makeIdentitySelect($person) {
        global $form;

        $list = $this->getIdentityList($person);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'identity_id', $list);
        $form->genericEnd();
    }

    public function makePersonDescription($person) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
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

    public function makeCharacteristicSelect($person, $gift) {
        global $form;

        $list = $this->getCharacteristicList($person, $gift);

        $currentList = $person->getCharacteristic($gift);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--characteristic');
        $form->getHidden('post', 'hash', $person->hash);

        foreach($list as $characteristic) {
            if(count($currentList) != null) {
                if(!in_array($characteristic, $currentList)) {
                    $form->getRadio('person', 'characteristic_id', $characteristic->name, $characteristic->id);
                }
            } else {
                $form->getRadio('person', 'characteristic_id', $characteristic->name, $characteristic->id);
            }
        }

        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }

    public function makeMilestoneSelect($person, $upbringing) {
        global $form;

        $list = $this->getMilestoneList($person, $upbringing);

        $currentList = $person->getMilestone($upbringing);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--milestone');
        $form->getHidden('post', 'hash', $person->hash);

        foreach($list as $milestone) {
            if(count($currentList) != null) {
                if(!in_array($milestone, $currentList)) {
                    $form->getRadio('person', 'milestone_id', $milestone->name, $milestone->id);
                }
            } else {
                $form->getRadio('person', 'milestone_id', $milestone->name, $milestone->id);
            }
        }

        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }

    public function makeSkillPurchase($person) {
        global $form;

        $skillList = $this->getSkillList($person);

        $currentList = $person->getAttribute($person->world->attributeSkill);
        $idList = [];

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--skill');
        $form->getHidden('post', 'hash', $person->hash);

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $form->getPurchase($current->name, $current->id, $current->maximum, $current->value);
            }
        }

        foreach($skillList as $skill) {
            if(!in_array($skill->id, $idList)) {
                $form->getPurchase($skill->name, $skill->id, $skill->maximum);
            }
        }

        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }

    public function makeExpertisePurchase($person) {
        global $form, $curl;

        $typeList = $curl->get('expertisetype')['data'];
        $skillList = $person->getAttribute($person->world->attributeSkill);
        $currentList = $person->getExpertise();
        $idList = [];

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--expertise');
        $form->getHidden('post', 'hash', $person->hash);

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

                $form->getPurchase($current->name, $current->id, $calculatedMax, $current->level);
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

                                $form->getPurchase($expertise->name, $expertise->id, $calculatedMax);
                            }
                        }
                    }
                }
            }
        }

        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }

    public function makeSupernaturalPurchase($person) {
        global $form;

        $supernaturalList = $this->getSupernaturalList($person);
        $expertiseList = $person->getExpertise();
        $currentList = $person->getAttribute($person->manifestation->attributeType);
        $idList = [];
        $expList = [];

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--supernatural');
        $form->getHidden('post', 'hash', $person->hash);

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $form->getPurchase($current->name, $current->id, $current->maximum, $current->value);
            }
        }

        foreach($expertiseList as $expertise) {
            $expList[] = $expertise->attribute['id'];
        }

        foreach($supernaturalList as $supernatural) {
            if(in_array($supernatural->id, $expList) && !in_array($supernatural->id, $idList)) {
                $form->getPurchase($supernatural->name, $supernatural->id, $supernatural->maximum);
            }
        }

        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }
}