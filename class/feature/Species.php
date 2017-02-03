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

    var $id, $name, $description, $playable, $maxAge, $icon;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('species/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];

        $this->name = $data['name'];

        $this->description = $data['description'];

        $this->playable = isset($data['playable'])
            ? $data['playable']
            : null;

        $this->maxAge = isset($data['max_age'])
            ? $data['max_age']
            : null;

        $this->icon = $data['icon_path'];

    }

    public function getAttributeList() {
        global $curl;

        $attributeList = [];

        $data = $curl->get('species-attribute/id/'.$this->id)['data'];

        foreach ($data as $value) {
            $attributeList[] = new Attribute($value['id']);
        }

        return $attributeList;
    }

    public function getWeaponList() {
        global $curl;

        $weaponList = [];

        $data = $curl->get('species-weapon/id/'.$this->id)['data'];

        foreach ($data as $value) {
            $weaponList[] = new Weapon($value['id']);
        }

        return $weaponList;
    }

}