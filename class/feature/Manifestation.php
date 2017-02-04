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

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('manifestation/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon_path'];
        $this->attributeType = $data['attributetype_id'];
        $this->expertiseType = $data['expertisetype_id'];
    }
}