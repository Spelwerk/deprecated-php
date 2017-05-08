<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:09
 */

class Background {
    var $id, $canon, $name, $description, $icon;

    var $species;

    var $manifestation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('background/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->species = $data['species_id'];

        $this->manifestation = $data['manifestation_id'];
    }
}

// todo has attribute

// todo has asset