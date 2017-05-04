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

    var $id, $canon, $playable, $name, $description, $icon;

    var $maxAge, $multiplySkill, $multiplyExpertise;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('species/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->playable = $data['playable'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->maxAge = $data['max_age'];
        $this->multiplySkill = intval($data['multiply_skill']);
        $this->multiplyExpertise = intval($data['multiply_expertise']);
    }

    public function getAttribute() {
        global $curl;

        $result = $curl->get('species-attribute/id/'.$this->id)['data'];

        $data = isset($result)
            ? $result
            : null;

        return $data;
    }

    public function getWeapon() {
        global $curl;

        $result = $curl->get('species-weapon/id/'.$this->id)['data'];

        $data = isset($result)
            ? $result
            : null;

        return $data;
    }
}