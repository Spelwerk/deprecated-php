<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */
class Story {

    var $id, $hash; // Variables

    var $owner, $get;

    var $name, $description;

    var $world; // Pointer at World

    var $person; // Array of Person

    var $npc;

    public function __construct($id = null, $hash = null) {
        global $Curl;


        $this->get = $hash != null ? 'story/hash/'.$hash : 'story/id/'.$id;

        $this->owner = $hash != null ? true : false;


        $data = $Curl->get($this->get)['data'][0];

        $this->id = $data['id'];

        $this->hash = $data['hash'];


        $this->name = $data['name'];

        $this->description = $data['description'];

        $this->world = $data['world_id'];
    }
}