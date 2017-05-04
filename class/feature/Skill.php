<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-05-04
 * Time: 17:32
 */
class Skill {
    var $id, $canon, $name, $description, $icon;

    var $species;

    var $value;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('skill/id/'.$id)['data'][0]
            : $array;

        $defaults = $curl->get('system/skill');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $defaults['maximum'];

        $this->species = $data['species_id'];

        $this->value = $data['value'];
    }
}