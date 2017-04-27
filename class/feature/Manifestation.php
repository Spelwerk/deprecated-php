<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:32
 */
class Manifestation {

    var $id, $name, $description, $icon;

    var $disciplineAttributeType, $skillAttributeType, $expertiseType, $powerAttribute;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('manifestation/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->icon = $data['icon_path'];

        $this->description = isset($data['manifestation_custom'])
            ? $data['manifestation_custom']
            : $data['description'];

        $this->disciplineAttributeType = $data['attributetype_id'];
        $this->skillAttribute = $data['skill_attribute_id'];
        $this->expertiseType = $data['expertisetype_id'];
        $this->powerAttribute = $data['power_attribute_id'];
    }
}