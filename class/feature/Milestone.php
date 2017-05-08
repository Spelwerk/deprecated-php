<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:35
 */

class Milestone {
    var $id, $canon, $name, $description, $icon;

    var $background;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $loyalty, $loyaltyOccupation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/milestone.png';

        $this->background = $data['background_id'];
        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];

        $this->loyalty = $data['loyalty_id'];
        $this->loyaltyOccupation = $data['loyalty_occupation'];
    }
}