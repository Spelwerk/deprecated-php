<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-01
 * Time: 18:58
 */

class Attribute {
    var $id, $canon, $name, $description, $icon;

    var $type, $maximum;

    var $value;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('attribute/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->type = $data['attributetype_id'];
        $this->maximum = isset($data['maximum']) ? $data['maximum'] : 0;

        $this->value = isset($data['value']) ? $data['value'] : 0;
    }
}