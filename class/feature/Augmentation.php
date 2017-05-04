<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 14:33
 */

class Augmentation {
    var $id, $canon, $name, $description, $price, $energy, $legal, $icon;

    var $weapon;

    var $quality;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('augmentation/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->energy = isset($data['quality_energy'])
            ? intval($data['energy']) * intval($data['quality_energy'])
            : intval($data['energy']);

        $this->legal = $data['legal'];

        $this->icon = 'http://cdn.spelwerk.com/file/2caee0a3adc7b135ffdd111fc150fb36442ffaa7.png';

        $this->weapon = $data['weapon_id'];

        $this->quality = $data['quality_id'];
    }
}

// todo has attribute

// todo has skill