<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
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

class World {

    var $id, $hash, $template, $popularity, $hidden;

    var $owner;

    var $name, $description;

    var $exists; // bool

    var $supernatural; // name of supernatural

    var $attributeType, $expertiseType;

    var $split;

    var $maximum;

    var $attributeList, $augmentationList, $bionicList, $casteList, $characteristicList, $expertiseList,
        $focusList, $identityList, $manifestationList, $milestoneList, $natureList, $speciesList,
        $weaponList;

    public function __construct($id = null, $hash = null, $array = null) {
        global $Curl;

        if(!$array) {
            $get = $hash != null
                ? 'world/hash/'.$hash
                : 'world/id/'.$id;

            $this->owner = $hash != null
                ? true
                : false;

            $data = $Curl->get($get)['data'][0];
        } else {
            $data = $array;
        }

        $this->id = intval($data['id']);

        $this->hash = $data['hash'];

        $this->name = $data['name'];

        $this->description = $data['description'];


        $this->template = intval($data['template']) == 1
            ? true
            : false;

        $this->popularity = $data['popularity'];

        $this->hidden = intval($data['hidden']) == 1
            ? true
            : false;

        $bionic = intval($data['bionic']) == 1
            ? true
            : false;

        $augmentation = intval($data['augmentation']) == 1
            ? true
            : false;

        $software = intval($data['software']) == 1
            ? true
            : false;

        $supernatural = intval($data['supernatural']) == 1
            ? true
            : false;

        $this->exists = [
            'bionic' => $bionic,
            'augmentation' => $augmentation,
            'software' => $software,
            'supernatural' => $supernatural
        ];

        if($this->exists['software'] == true)
            $this->supernatural = $data['supernatural_name'];

        $this->attributetype = [
            'skill' => intval($data['skill_attributetype_id'])
        ];

        $this->expertisetype = [
            'attribute' => intval($data['attribute_expertisetype_id']),
            'dice' => intval($data['dice_expertisetype_id'])
        ];

        $this->split = [
            'supernatural' => intval($data['supernatural']),
            'skill' => intval($data['skill']),
            'expertise' => intval($data['expertise']),
            'milestone' => intval($data['milestone']),
            'relationship' => intval($data['relationship'])
        ];

        $this->maximum = [
            'gift' => intval($data['max_characteristic_gift']),
            'imperfection' => intval($data['max_characteristic_imperfection']),
            'supernatural' => intval($data['max_supernatural']),
            'skill' => intval($data['max_skill']),
            'expertise' => intval($data['max_expertise']),
            'upbringing' => intval($data['max_milestone_upbringing']),
            'flexible' => intval($data['max_milestone_flexible']),
            'relationship' => intval($data['max_relationship'])
        ];
    }

    public function setAttribute($type = null, $species = null) {
        global $Curl;

        $this->attributeList = [];

        if(!$type && !$species) {
            $data = $Curl->get('world-attribute/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-attribute/id/'.$this->id.'/type/'.$type.'/species/'.$species)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->attributeList, new Attribute($value));
            }
        }
    }

    public function setAugmentation($bionic = null) {
        global $Curl;

        $this->augmentationList = [];

        if(!$bionic) {
            $data = $Curl->get('world-augmentation/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-augmentation/id/'.$this->id.'/bionic/'.$bionic)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->augmentationList, new Augmentation($value));
            }
        }
    }

    public function setBionic($bodypart = null) {
        global $Curl;

        $this->bionicList = [];

        if(!$bodypart) {
            $data = $Curl->get('world-bionic/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-bionic/id/'.$this->id.'/bodypart/'.$bodypart)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->bionicList, new Bionic($value));
            }
        }
    }

    public function setCaste() {
        global $Curl;

        $this->casteList = [];

        $data = $Curl->get('world-caste/id/'.$this->id)['data'];

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->casteList, new Caste($value));
            }
        }
    }

    public function setCharacteristic($gift = null, $species = null, $manifestation = null) {
        global $Curl;

        $this->characteristicList = [];

        if(!$gift && !$species && !$manifestation) {
            $data = $Curl->get('world-characteristic/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-characteristic/id/'.$this->id.'/gift/'.$gift.'/species/'.$species.'/manifestation/'.$manifestation)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->characteristicList, new Characteristic($value));
            }
        }
    }

    public function setExpertise($skill = null, $type = null, $species = null, $manifestation = null) {
        global $Curl;

        $this->expertiseList = [];

        if(!$skill && !$type && !$species && !$manifestation) {
            $data = $Curl->get('world-expertise/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-expertise/id/'.$this->id.'/skill/'.$skill.'/type/'.$type.'/species/'.$species.'/manifestation/'.$manifestation)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->expertiseList, new Expertise($value));
            }
        }
    }

    public function setFocus($manifestation = null) {
        global $Curl;

        $this->focusList = [];

        if(!$manifestation) {
            $data = $Curl->get('world-focus/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-focus/id/'.$this->id.'/manifestation/'.$manifestation)['data'];
        }

        foreach($data as $value) {
            array_push($this->focusList, new Focus($value));
        }
    }

    public function setIdentity() {
        global $Curl;

        $this->identityList = [];

        $data = $Curl->get('world-identity/id/'.$this->id)['data'];

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->identityList, new Identity($value));
            }
        }
    }

    public function setManifestation() {
        global $Curl;

        $this->manifestationList = [];

        $data = $Curl->get('world-manifestation/id/'.$this->id)['data'];

        if($data[0]) {
            foreach($data as $value) {
                array_push($this->manifestationList, new Manifestation($value));
            }
        }
    }

    public function setMilestone($upbringing = null, $caste = null, $species = null, $manifestation = null) {
        global $Curl;

        $this->milestoneList = [];

        if(!$upbringing && !$caste && !$species && !$manifestation) {
            $data = $Curl->get('world-milestone/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-milestone/id/'.$this->id.'/upbringing/'.$upbringing.'/caste/'.$caste.'/species/'.$species.'/manifestation/'.$manifestation)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->milestoneList, new Milestone($value));
            }
        }
    }

    public function setNature() {
        global $Curl;

        $this->natureList = [];

        $data = $Curl->get('world-nature/id/'.$this->id)['data'];

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->natureList, new Nature($value));
            }
        }
    }

    public function setSpecies($playable = null) {
        global $Curl;

        $this->speciesList = [];

        if(!$playable) {
            $data = $Curl->get('world-species/id/'.$this->id);
        } else {
            $data = $Curl->get('world-species/id/'.$this->id.'/playable/'.$playable)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->speciesList, new Species($value));
            }
        }
    }

    public function setWeapon($type = null) {
        global $Curl;

        $this->weaponList = [];

        if(!$type) {
            $data = $Curl->get('world-weapon/id/'.$this->id)['data'];
        } else {
            $data = $Curl->get('world-weapon/id/'.$this->id.'/type/'.$type)['data'];
        }

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->weaponList, new Weapon($value));
            }
        }
    }

}