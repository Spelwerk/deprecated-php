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

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->formStart([
                'do' => 'basic--put',
                'return' => 'content/skill',
                'context' => 'skill',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $component->wrapEnd();
            $form->formEnd();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/skill');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton('/content/skill/'.$this->id.'/edit','Edit');
            //todo link to delete();
        }
    }
}