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

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];

        $this->name = $data['name'];

        $this->description = $data['description'];

        $this->attribute = [
            'id' => $data['attribute_id'],
            'name' => $data['attribute_name'],
            'value' => $data['attribute_value']
        ];

        $this->loyalty = [
            'id' => $data['loyalty_id'],
            'name' => $data['loyalty_name'],
            'occupation' => $data['loyalty_occupation']
        ];

    }

}