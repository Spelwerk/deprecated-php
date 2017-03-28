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
require_once('feature/Background.php');
require_once('feature/Characteristic.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Protection.php');
require_once('feature/Species.php');
require_once('feature/Weapon.php');
require_once('feature/Wound.php');

class World {

    var $id, $hash, $template, $popularity, $hidden, $owner, $name, $description, $money;

    var $isTemplate, $isOwner, $isCalculated;

    var $supernaturalName;

    var $attributeBody, $attributeCombat, $attributeConsumable, $attributeDamage, $attributeExperience,
        $attributePotential, $attributeProtection, $attributeReputation, $attributeSkill, $attributeWound;

    var $existsBionic, $existsAugmentation, $existsSoftware, $existsSupernatural;

    var $splitSupernatural, $splitSkill, $splitExpertise, $splitMilestone, $splitRelationship;

    var $maxGift, $maxImperfection, $maxSupernatural, $maxSkill, $maxExpertise, $maxMilestone,
        $maxRelationship;

    var $expertiseAttribute, $expertiseDice;

    var $experience, $woundLethal, $woundSerious, $tolerance;

    public function __construct($id = null, $hash = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('world/id/'.$id)['data'][0]
            : $array;

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->isOwner = isset($hash) && $hash == $data['hash']
            ? true
            : false;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->popularity = $data['popularity'];
        $this->hidden = $data['hidden'];
        $this->money = $data['money_attribute_id'];

        $this->isTemplate = $data['template'];
        $this->isCalculated = $data['calculated'];

        // Hard Coded values for the System // todo add all these to database?
        $this->attributeBody = 1;
        $this->attributeCombat = 2;
        $this->attributeConsumable = 8;
        $this->attributeDamage = 3;
        $this->attributeExperience = 9;
        $this->attributePower = 7;
        $this->attributeProtection = 4;
        $this->attributeReputation = 6;
        $this->attributeWound = 5;

        $this->attributeSkill = $data['skill_attributetype_id'];
        $this->expertiseAttribute = $data['attribute_expertisetype_id'];
        $this->expertiseDice = $data['dice_expertisetype_id'];

        $this->existsBionic = $data['bionic'];
        $this->existsAugmentation = $data['augmentation'];
        $this->existsSoftware = $data['software'];
        $this->existsSupernatural = $data['supernatural'];

        $this->splitSupernatural = intval($data['split_supernatural']);
        $this->splitSkill = intval($data['split_skill']);
        $this->splitExpertise = intval($data['split_expertise']);
        $this->splitMilestone = intval($data['split_milestone']);
        $this->splitRelationship = intval($data['split_relationship']);

        $this->maxGift = intval($data['max_characteristic_gift']);
        $this->maxImperfection = intval($data['max_characteristic_imperfection']);
        $this->maxSupernatural = intval($data['max_supernatural']);
        $this->maxSkill = intval($data['max_skill']);
        $this->maxExpertise = intval($data['max_expertise']);
        $this->maxMilestone = intval($data['max_milestone']);
        $this->maxRelationship = intval($data['max_relationship']);

        $this->supernaturalName = isset($data['supernatural_name'])
            ? $data['supernatural_name']
            : null;

        $this->experience = 22;
        $this->woundLethal = 14;
        $this->woundSerious = 15;
        $this->tolerance = 1;
    }


    public function getAttribute($type = null, $species = null) {
        global $curl;

        $arrayList = null;

        $get = 'world-attribute/id/'.$this->id;

        if(isset($type)) {
            $get = isset($species)
                ? 'world-attribute/id/'.$this->id.'/type/'.$type.'/species/'.$species
                : 'world-attribute/id/'.$this->id.'/type/'.$type;
        }

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAugmentation($bionic = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'world-augmentation/id/'.$this->id.'/bionic/'.$bionic
            : 'world-augmentation/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Augmentation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBionic($bodypart = null) {
        global $curl;

        $arrayList = null;

        $get = isset($bodypart)
            ? 'world-bionic/id/'.$this->id.'/bodypart/'.$bodypart
            : 'world-bionic/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Bionic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBackground() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world-background/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Background(null, $array);
            }
        }

        return $arrayList;
    }

    public function getCharacteristic($gift = null, $species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world-characteristic/id/'.$this->id;

        if(isset($gift) && isset($species)) {
            $get = isset($manifestation)
                ? 'world-characteristic/id/'.$this->id.'/gift/'.$gift.'/species/'.$species.'/manifestation/'.$manifestation
                : 'world-characteristic/id/'.$this->id.'/gift/'.$gift.'/species/'.$species;
        } else if(isset($gift)) {
            $get = 'world-characteristic/id/'.$this->id.'/gift/'.$gift;
        }

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Characteristic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($type = null, $skill = null, $species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world-expertise/id/'.$this->id;

        if(isset($skill) && isset($type) && isset($species)) {
            $get = isset($manifestation)
                ? 'world-expertise/id/'.$this->id.'/skill/'.$skill.'/type/'.$type.'/species/'.$species.'/manifestation/'.$manifestation
                : 'world-expertise/id/'.$this->id.'/skill/'.$skill.'/type/'.$type.'/species/'.$species;
        } else if(isset($type)) {
            $get = 'world-expertise/id/'.$this->id.'/type/'.$type;
        }

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Expertise(null, $array);
            }
        }

        return $arrayList;
    }

    public function getFocus($manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = isset($manifestation)
            ? 'world-focus/id/'.$this->id.'/manifestation/'.$manifestation
            : 'world-focus/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Focus(null, $array);
            }
        }

        return $arrayList;
    }

    public function getIdentity() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world-identity/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Identity(null, $array);
            }
        }

        return $arrayList;
    }

    public function getManifestation() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world-manifestation/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Manifestation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone($background = null, $species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world-milestone/id/'.$this->id;

        if(isset($background) && isset($species)) {
            $get = isset($manifestation)
                ? 'world-milestone/id/'.$this->id.'/background/'.$background.'/species/'.$species.'/manifestation/'.$manifestation
                : 'world-milestone/id/'.$this->id.'/background/'.$background.'/species/'.$species;
        }

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    public function getNature() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world-nature/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Nature(null, $array);
            }
        }

        return $arrayList;
    }

    public function getProtection($type = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'world-protection/id/'.$this->id.'/type/'.$type
            : 'world-protection/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSpecies() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world-species/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Species(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeapon($group = null) {
        global $curl;

        $arrayList = null;

        $get = isset($group)
            ? 'world-weapon/id/'.$this->id.'/group/'.$group
            : 'world-weapon/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Weapon(null, $array);
            }
        }

        return $arrayList;
    }
}