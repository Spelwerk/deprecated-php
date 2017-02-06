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

    var $id, $hash, $template, $popularity, $hidden, $owner, $name, $description, $exists, $split, $maximum;

    var $supernaturalName;

    var $attributeBody, $attributeCombat, $attributeConsumable, $attributeDamage, $attributeExperience,
        $attributePotential, $attributeProtection, $attributeReputation, $attributeSkill, $attributeWound;

    var $expertiseAttribute, $expertiseDice;

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

        $this->attributeBody = 1;
        $this->attributeCombat = 2;
        $this->attributeConsumable = 8;
        $this->attributeDamage = 3;
        $this->attributeExperience = 9;
        $this->attributePotential = 7;
        $this->attributeProtection = 4;
        $this->attributeReputation = 6;
        $this->attributeSkill = $data['skill_attributetype_id'];
        $this->attributeWound = 5;

        $this->expertiseAttribute = $data['attribute_expertisetype_id'];
        $this->expertiseDice = $data['dice_expertisetype_id'];

        $this->exists = [
            'bionic' => $data['bionic'],
            'augmentation' => $data['augmentation'],
            'software' => $data['software'],
            'supernatural' => $data['supernatural']
        ];

        if($this->exists['supernatural'] == true)
            $this->supernaturalName = $data['supernatural_name'];

        $this->split = [
            'supernatural' => intval($data['split_supernatural']),
            'skill' => intval($data['split_skill']),
            'expertise' => intval($data['split_expertise']),
            'milestone' => intval($data['split_milestone']),
            'relationship' => intval($data['split_relationship'])
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
}