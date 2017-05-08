<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:32
 */

class Manifestation {
    var $id, $canon, $name, $description, $icon;

    var $power;

    var $skill;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('manifestation/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->power = $data['power_id'];

        $this->skill = $data['skill_id'];
    }
}