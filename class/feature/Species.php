<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:33
 */

require_once('Attribute.php');
require_once('Weapon.php');

class Species {

    var $id, $name, $description, $playable, $max_age;

    var $attributeList, $weaponList;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->playable = $array['playable'];

        $this->max_age = $array['max_age'];

        $this->icon = $array['icon_path'];

    }

    public function setAttribute() {
        global $curl;

        $this->attributeList = [];

        $data = $curl->get('species-attribute/id/'.$this->id)['data'];

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->attributeList, new Attribute([
                    'id' => $value['attribute_id'],
                    'name' => $value['attribute_name']
                ]));
            }
        }
    }

    public function setWeapon() {
        global $curl;

        $this->weaponList = [];

        $data = $curl->get('species-weapon/id/'.$this->id)['data'];

        if($data[0]) {
            foreach ($data as $value) {
                array_push($this->weaponList, new Weapon([
                    'id' => $value['weapon_id'],
                    'name' => $value['weapon_name']
                ]));
            }
        }
    }

}