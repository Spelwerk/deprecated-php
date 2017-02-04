<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-01
 * Time: 18:58
 */

class Attribute
{
    var $id, $name, $description, $protected;

    var $type;

    var $value, $default, $maximum;

    var $icon;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('attribute/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->maximum = $data['maximum'];
        $this->protected = $data['protected'];

        $this->value = isset($data['value'])
            ? $data['value']
            : null;

        $this->default = isset($data['default'])
            ? $data['default']
            : null;

        $this->type = [
            'id' => $data['attributetype_id'],
            'name' => $data['attributetype_name'],
        ];

        $this->icon = $data['icon_path'];
    }
}