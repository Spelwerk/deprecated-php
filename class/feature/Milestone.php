<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:35
 */
class Milestone {

    var $id, $name, $description, $icon;

    var $backgroundId, $backgroundName, $speciesId, $speciesName, $manifestationId, $manifestationName;

    var $attribute, $relationship;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];

        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->backgroundId = $data['background_id'];
        $this->speciesId = $data['species_id'];
        $this->manifestationId = $data['manifestation_id'];
        $this->attributeId = $data['attribute_id'];
        $this->loyaltyId = $data['loyalty_id'];

        $this->icon = '/img/person/milestone.png';
    }
}