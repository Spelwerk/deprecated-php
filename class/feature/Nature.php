<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:31
 */

class Nature {
    var $id, $name, $description, $icon;

    var $attribute, $attributeValue;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('nature/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];
    }
}