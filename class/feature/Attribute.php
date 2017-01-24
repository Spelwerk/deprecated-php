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

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->maximum = $array['maximum'];

        $this->value = isset($array['value']) ? $array['value'] : null;

        $this->default = isset($array['default']) ? $array['default'] : null;

        $this->protected = $array['protected'];

        $this->type = [
            'id' => $array['attributetype_id'],
            'name' => $array['attributetype_name'],
        ];

        $this->icon = $array['icon_path'];
    }
}