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

    var $worldList;

    public function __construct() {

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

    public function setWorldList() {
        global $curl;

        $this->worldList = [];

        $data = $curl->get('world/template')['data'];

        foreach ($data as $value) {
            array_push($this->worldList, new World(null,null,$value));
        }
    }

    public function getPersonCreationStep($Person) {
        if(!$Person->id || !$Person->world || !$Person->species['id'] || !$Person->name['nick'] || !$Person->description['age'] || !$Person->description['occupation'])
            return 'world,species,nickname,age,occupation,supernatural';

        if(!$Person->caste['id'])
            return 'caste';

        if(!$Person->nature['id'])
            return 'nature';

        if(!$Person->identity['id'])
            return 'identity';

        if($Person->supernatural) {

            if(!$Person->manifestation['id'])
                return 'manifestation';

            if(!$Person->focus['id'])
                return 'focus';

            //$Person->setAttributeList();

            $potentialMissing = true;

            foreach($Person->attributeList as $Attribute) {
                if($Attribute['id'] == $this->potential['potential']) {
                    $potentialMissing = false;
                }
            }

            if($potentialMissing)
                return 'potential';
        }

        if(!$Person->attributeList[$this->reputation['honor']])
            return 'honor';

        if(!$Person->attributeList[$this->reputation['infamy']])
            return 'infamy';

        if(!$Person->characteristicList)
            return 'characteristic';

        if(!$Person->milestoneList)
            return 'milestone';

        // skill

        // expertise

        return 0;
    }
}