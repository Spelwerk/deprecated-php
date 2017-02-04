<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:15
 */
class Expertise {

    var $id, $name, $description, $hidden, $level, $maximum, $weapon, $icon;

    var $type, $skill, $species, $manifestation, $attribute;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('expertise/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->hidden = $data['hidden'];
        $this->maximum = $data['maximum'];
        $this->weapon = $data['give_weapon'];
        $this->icon = $data['icon_path'];

        $this->level = isset($data['level'])
            ? $data['level']
            : null;

        $this->type = [
            'id' => $data['expertisetype_id'],
            'name' => $data['expertisetype_name']
        ];

        $this->skill = [
            'id' => $data['skill_attribute_id'],
            'name' => $data['skill_attribute_name'],
            'required' => $data['skill_attribute_required'], // when you can get level 1
            'increment' => $data['skill_attribute_increment'], // when you can get level 2
            'startsat' => $data['startsat'] // bonus starts at
        ];

        $this->species = [
            'id' => $data['species_id'],
            'name' => $data['species_name']
        ];

        $this->manifestation = [
            'id' => $data['manifestation_id'],
            'name' => $data['manifestation_name']
        ];

        $this->attribute = [
            'id' => $data['give_attribute_id'],
            'name' => $data['give_attribute_name'],
            'value' => $this->level
        ];
    }
}