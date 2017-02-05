<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-10
 * Time: 09:09
 */

require_once('feature/Attribute.php');
require_once('feature/Augmentation.php');
require_once('feature/Bionic.php');
require_once('feature/Caste.php');
require_once('feature/Characteristic.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Species.php');
require_once('feature/Weapon.php');

require_once('World.php');

class Person {

    var $id, $hash, $template, $popularity, $cheated, $supernatural, $owner;

    var $nickname, $firstname, $surname, $age, $gender, $occupation;

    var $description, $behaviour, $appearance, $features, $personality;

    var $world, $species, $caste, $nature, $identity, $manifestation, $focus;

    public function __construct($id = null, $hash = null) {
        global $curl;

        $get = $hash != null
            ? 'person/hash/'.$hash
            : 'person/id/'.$id;

        $data = $curl->get($get)['data'][0];

        $this->owner = isset($hash)
            ? true
            : false;

        $this->id = $data['id'];
        $this->hash = $data['hash'];

        $this->nickname = $data['nickname'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];

        $this->age = $data['age'];
        $this->gender = $data['gender'];
        $this->occupation = $data['occupation'];

        $this->description = $data['description'];
        $this->behaviour = $data['behaviour'];
        $this->appearance = $data['appearance'];
        $this->features = $data['features'];
        $this->personality = $data['personality'];

        $this->template = $data['template'];
        $this->cheated = $data['cheated'];
        $this->supernatural = $data['supernatural'];
        $this->popularity = $data['popularity'];

        $this->world = isset($data['world_id'])
            ? new World($data['world_id'])
            : null;

        $this->species = isset($data['species_id'])
            ? new Species($data['species_id'])
            : null;

        $this->caste = isset($data['caste_id'])
            ? new Caste($data['caste_id'])
            : null;

        $this->nature = isset($data['nature_id'])
            ? new Nature($data['nature_id'])
            : null;

        $this->identity = isset($data['identity_id'])
            ? new Identity($data['identity_id'])
            : null;

        $this->manifestation = isset($data['manifestation_id'])
            ? new Manifestation($data['manifestation_id'])
            : null;

        $this->focus = isset($data['focus_id'])
            ? new Focus($data['focus_id'])
            : null;
    }


    public function getCharacteristic($gift) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-characteristic/id/'.$this->id.'/gift/'.$gift);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Characteristic(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getMilestone($upbringing) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-milestone/id/'.$this->id.'/upbringing/'.$upbringing);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Milestone(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getAttribute($type) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-attribute/id/'.$this->id.'/type/'.$type);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Attribute(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getExpertise() {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-expertise/id/'.$this->id);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $expertise) {
                $arrayList[] = new Expertise(null, $expertise);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getWeapon() {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-weapon/id/'.$this->id);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Weapon(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }


    function countAttribute($type) {
        $list = $this->getAttribute($type);

        $total = 0;

        if(isset($list)) {
            foreach($list as $attribute) {
                $total += $attribute->value;
            }
        }

        return $total;
    }

    function countExpertise() {
        $list = $this->getExpertise();

        $total = 0;

        if(isset($list)) {
            foreach($list as $expertise) {
                if($expertise->level == 1) {
                    $total += $expertise->level;
                } else {
                    $math = 1;

                    for($i = 2; $i <= $expertise->level; $i++) {
                        $math += $i * 2;
                    }

                    $total += $math;
                }
            }
        }

        return $total;
    }


    public function canCharacteristic($gift) {
        $gName = $gift == 1
            ? 'gift'
            : 'imperfection';

        $currentCharacteristic = count($this->getCharacteristic($gift));
        $maximum = $this->world->maximum[$gName];

        return floor($maximum - $currentCharacteristic);
    }

    public function canMilestone($upbringing) {
        $uName = $upbringing == 1
            ? 'upbringing'
            : 'flexible';

        $currentMilestone = count($this->getMilestone($upbringing));
        $ageSplit = $this->age / $this->world->split['milestone'];
        $worldMaximum = $this->world->maximum[$uName];

        $maximum = $ageSplit > $worldMaximum
            ? $worldMaximum
            : $ageSplit;

        return floor($maximum - $currentMilestone);
    }

    public function canSkill() {
        $currentSkill = $this->countAttribute($this->world->attributeSkill);
        $ageSplit = $this->age / $this->world->split['skill'];
        $worldMaximum = $this->world->maximum['skill'];

        $maximum = $ageSplit > $worldMaximum
            ? $worldMaximum
            : $ageSplit;

        return floor($maximum - $currentSkill);
    }

    public function canExpertise() {
        $currentExpertise = $this->countExpertise();
        $ageSplit = $this->age / $this->world->split['expertise'];
        $worldMaximum = $this->world->maximum['expertise'];

        $maximum = $ageSplit > $worldMaximum
            ? $worldMaximum
            : $ageSplit;

        return floor($maximum - $currentExpertise);
    }

    public function canSupernatural() {
        $currentSupernatural = $this->countAttribute($this->manifestation->attributeType);
        $ageSplit = $this->age / $this->world->split['supernatural'];
        $worldMaximum = $this->world->maximum['supernatural'];

        $maximum = $ageSplit > $worldMaximum
            ? $worldMaximum
            : $ageSplit;

        return floor($maximum - $currentSupernatural);
    }
}