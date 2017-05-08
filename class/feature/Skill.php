<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-05-04
 * Time: 17:32
 */
class Skill {
    var $id, $canon, $name, $description, $icon;

    var $species;

    var $value;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('skill/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $defaults = $curl->get('system/skill');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $defaults['maximum'];

        $this->species = $data['species_id'];

        $this->value = isset($data['value']) ? $data['value'] : 0;
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/skill');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name

        if($this->isOwner) {
            //$component->h1('Manage');
            //todo link to put();
            //todo link to delete();
        }
    } //todo
}