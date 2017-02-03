<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:15
 */
class Expertise {

    var $id, $name, $description, $hidden, $level, $maximum, $weapon;

    var $type, $skill, $species, $manifestation, $attribute;

    var $icon;

    public function __construct($id = null, $array = null) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->hidden = $array['hidden'];

        $this->level = $array['level'];

        $this->maximum = $array['maximum'];

        $this->weapon = $array['give_weapon'];

        $this->type = [
            'id' => $array['expertisetype_id'],
            'name' => $array['expertisetype_name']
        ];

        $this->skill = [
            'id' => $array['skill_attribute_id'],
            'name' => $array['skill_attribute_name'],
            'required' => $array['skill_attribute_required'],
            'increment' => $array['skill_attribute_increment'],
            'startsat' => $array['startsat']
        ];

        $this->species = [
            'id' => $array['species_id'],
            'name' => $array['species_name']
        ];

        $this->manifestation = [
            'id' => $array['manifestation_id'],
            'name' => $array['manifestation_name']
        ];

        $this->attribute = [
            'id' => $array['give_attribute_id'],
            'name' => $array['give_attribute_name'],
            'value' => $array['level']
        ];

        $this->icon = $array['icon_path'];

    }

}