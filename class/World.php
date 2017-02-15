<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

class World {

    var $id, $hash, $template, $popularity, $hidden, $owner, $name, $description, $money;

    var $supernaturalName;

    var $attributeBody, $attributeCombat, $attributeConsumable, $attributeDamage, $attributeExperience,
        $attributePotential, $attributeProtection, $attributeReputation, $attributeSkill, $attributeWound;

    var $existsBionic, $existsAugmentation, $existsSoftware, $existsSupernatural;

    var $splitSupernatural, $splitSkill, $splitExpertise, $splitMilestone, $splitRelationship;

    var $maxGift, $maxImperfection, $maxSupernatural, $maxSkill, $maxExpertise, $maxUpbringing, $maxFlexible,
        $maxRelationship;

    var $expertiseAttribute, $expertiseDice;

    var $woundLethal, $woundSerious;

    public function __construct($id = null, $hash = null, $array = null) {
        global $curl;

        $data = null;

        if(isset($hash)) {
            $data = $curl->get('world/hash/'.$hash)['data'][0];
        }

        if(isset($id)) {
            $data = $curl->get('world/id/'.$id)['data'][0];
        }

        if(isset($array)) {
            $data = $array;
        }

        $this->owner = isset($hash)
            ? true
            : false;

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->template = $data['template'];
        $this->popularity = $data['popularity'];
        $this->hidden = $data['hidden'];
        $this->money = $data['money_attribute_id'];

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
        $this->maxUpbringing = intval($data['max_milestone_upbringing']);
        $this->maxFlexible = intval($data['max_milestone_flexible']);
        $this->maxRelationship = intval($data['max_relationship']);

        $this->supernaturalName = $data['supernatural_name'];

        $this->experience = 22;
        $this->woundLethal = 14;
        $this->woundSerious = 15;
    }

    public function getAttribute($type) {
        global $curl;

        $arrayList = null;

        $return = $curl->get('world-attribute/id/'.$this->id.'/type/'.$type);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }
}