<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:11
 */
class Characteristic {

    var $id, $name, $description, $gift;

    var $species, $manifestation, $attribute;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->gift = $array['gift'];

        $this->species = [
            'id' => $array['species_id'],
            'name' => $array['species_name']
        ];

        $this->manifestation = [
            'id' => $array['manifestation_id'],
            'name' => $array['manifestation_name']
        ];

        $this->attribute = [
            'id' => $array['attribute_id'],
            'name' => $array['attribute_name'],
            'value' => $array['attribute_value']
        ];

        $this->icon = $array['icon_path'];

    }

}