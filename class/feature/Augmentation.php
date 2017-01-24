<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 14:33
 */
class Augmentation {

    var $id, $name, $description, $legal, $price, $energy;

    var $attribute, $quality, $weapon;

    var $bionic;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->legal = $array['legal'];

        $price = intval($array['price']) * intval($array['quality_price']);

        $this->price = $price;

        $energy = intval($array['energy']) + intval($array['quality_energy']);

        $this->energy = $energy;

        $this->bionic = [
            'id' => $array['bionic_id'],
            'name' => $array['bionic_name']
        ];

        $this->attribute = [
            'id' => $array['attribute_id'],
            'name' => $array['attribute_name'],
            'value' => $array['attribute_value']
        ];

        $this->quality = [
            'id' => $array['quality_id'],
            'name' => $array['quality_name']
        ];

        $this->weapon = [
            'id' => $array['weapon_id'],
            'name' => $array['weapon_name']
        ];

        $this->icon = $array['icon_path'];

    }
}