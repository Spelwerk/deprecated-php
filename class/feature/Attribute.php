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

    public function makeForm() {
        global $Form;

        $t = 'attribute';

        $Form->varchar($t, 'name');
        $Form->text($t, 'description');
        $Form->bool($t, 'protected');
        $Form->foreign($t, 'attributetype', 'attributetype');
        $Form->number($t, 'value');
        $Form->number($t, 'default');
        $Form->number($t, 'maximum');
    }
}