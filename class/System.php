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
                if(count($person->getCharacteristic(1)) < $person->world->maximum['gift']) {
                    $this->makeCharacteristicSelect($person, 1);

                } else if(count($person->getCharacteristic(0)) < $person->world->maximum['imperfection']) {
                    $this->makeCharacteristicSelect($person, 0);

                } else if(count($person->getMilestone(1)) < $person->world->maximum['upbringing']) {
                    $this->makeMilestoneSelect($person, 1);

                } else if(count($person->getMilestone(0)) < $person->world->maximum['flexible'] && count($person->getMilestone(0)) < ($person->age / $person->world->split['milestone'])) {
                    $this->makeMilestoneSelect($person, 0);

                } else {
                    // purchase attribute

                    // purchase expertise

                    // purchase supernatural
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

    function getManifestationList($worldId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-manifestation/id/'.$worldId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Manifestation(null, $array);
        }

        return $arrayList;
    }

    function getFocusList($worldId, $manifestationId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-focus/id/'.$worldId.'/manifestation/'.$manifestationId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Focus(null, $array);
        }

        return $arrayList;
    }

    function getCasteList($worldId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-caste/id/'.$worldId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Caste(null, $array);
        }

        return $arrayList;
    }

    function getNatureList($worldId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-nature/id/'.$worldId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Nature(null, $array);
        }

        return $arrayList;
    }

    function getIdentityList($worldId) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-identity/id/'.$worldId)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Identity(null, $array);
        }

        return $arrayList;
    }

    function getCharacteristicList($person, $gift) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-characteristic/id/'.$person->world->id.'/gift/'.$gift.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Characteristic(null, $array);
        }

        return $arrayList;
    }

    function getMilestoneList($person, $upbringing) {
        global $curl;

        $arrayList = [];

        $data = $curl->get('world-milestone/id/'.$person->world->id.'/upbringing/'.$upbringing.'/caste/'.$person->caste->id.'/species/'.$person->species->id.'/manifestation/'.$person->manifestation->id)['data'];

        foreach ($data as $array) {
            $arrayList[] = new Milestone(null, $array);
        }

        return $arrayList;
    }

    public function makeWorldSelect() {
        global $form;

        $list = $this->getWorldList();

        $form->genericStart();
        $form->genericSelect('person', 'world_id', $list);
        $form->genericEnd();
    }

    public function makeSpeciesSelect($world) {
        global $form;

        $list = $this->getSpeciesList($world->id);

        $form->genericStart();
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

        $list = $this->getManifestationList($person->world->id);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'manifestation_id', $list);
        $form->genericEnd();
    }

    public function makeFocusSelect($person) {
        global $form;

        $list = $this->getFocusList($person->world->id, $person->manifestation->id);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'focus_id', $list);
        $form->genericEnd();
    }

    public function makeCasteSelect($person) {
        global $form;

        $list = $this->getCasteList($person->world->id);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'caste_id', $list);
        $form->genericEnd();
    }

    public function makeNatureSelect($person) {
        global $form;

        $list = $this->getNatureList($person->world->id);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--put');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'nature_id', $list);
        $form->genericEnd();
    }

    public function makeIdentitySelect($person) {
        global $form;

        $list = $this->getIdentityList($person->world->id);

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

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--characteristic');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'characteristic_id', $list);
        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }

    public function makeMilestoneSelect($person, $upbringing) {
        global $form;

        $list = $this->getMilestoneList($person, $upbringing);

        $form->genericStart();
        $form->getHidden('post', 'return', '');
        $form->getHidden('post', 'do', 'person--milestone');
        $form->getHidden('post', 'hash', $person->hash);

        $form->genericSelect('person', 'milestone_id', $list);
        $form->getHidden('person', 'person_id', $person->id);
        $form->genericEnd();
    }
}