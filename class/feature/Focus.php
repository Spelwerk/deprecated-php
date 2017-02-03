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

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('focus/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];

        $this->name = $data['name'];

        $this->description = $data['description'];

        $this->attribute = [
            'id' => $data['attribute_id'],
            'name' => $data['attribute_name'],
            'value' => $data['attribute_value']
        ];

        $this->manifestation = [
            'id' => $data['manifestation_id'],
            'name' => $data['manifestation_name']
        ];

        $this->icon = $data['icon_path'];

    }

}