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

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('augmentation/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

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

        $this->quality = isset($data['quality_id']) ? $data['quality_id'] : null;

        $this->siteLink = '/content/augmentation/id/'.$this->id;
    }
}

// todo has attribute

// todo has skill