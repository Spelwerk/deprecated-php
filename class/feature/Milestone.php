<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:35
 */
class Milestone {

    var $id, $name, $description, $upbringing;

    var $attribute, $relationship;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->attribute = [
            'id' => $array['attribute_id'],
            'name' => $array['attribute_name'],
            'value' => $array['attribute_value']
        ];

        $this->loyalty = [
            'id' => $array['loyalty_id'],
            'name' => $array['loyalty_name'],
            'occupation' => $array['loyalty_occupation']
        ];

    }

}