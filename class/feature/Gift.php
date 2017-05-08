<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:11
 */

class Gift {
    var $id, $canon, $name, $description, $icon;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('gift/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/gift.png';

        $this->species = $data['species_id'];

        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];
    }
}