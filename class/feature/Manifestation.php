<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:32
 */
class Manifestation {

    var $id, $name, $description;

    var $attributeType, $expertiseType;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->attributeType = [
            'id' => $array['attributetype_id'],
            'name' => $array['attributetype_name']
        ];

        $this->expertiseType = [
            'id' => $array['expertisetype_id'],
            'name' => $array['expertisetype_name']
        ];

        $this->icon = $array['icon_path'];

    }

}