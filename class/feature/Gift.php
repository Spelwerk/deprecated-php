<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:11
 */

class Gift {
    var $id, $canon, $name, $description, $icon;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('gift/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/gift.png';

        $this->species = $data['species_id'];

        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];

        $this->siteLink = '/content/gift/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->formStart([
                'do' => 'basic--put',
                'return' => 'content/gift',
                'context' => 'gift',
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

        $component->returnButton('/content/gift');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name
        $component->p('Attribute ID: '.$this->attribute); //todo api return name
        $component->p('Attribute Value: '.$this->attributeValue); //todo api return name
        $component->p('Skill ID: '.$this->skill); //todo api return name
        $component->p('Skill Value: '.$this->skillValue); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }
}