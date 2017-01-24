<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:37
 */
class Focus {

    var $id, $name, $description;

    var $attribute, $manifestation;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->attribute = [
            'id' => $array['attribute_id'],
            'name' => $array['attribute_name'],
            'value' => $array['attribute_value']
        ];

        $this->manifestation = [
            'id' => $array['manifestation_id'],
            'name' => $array['manifestation_name']
        ];

        $this->icon = $array['icon_path'];

    }

}