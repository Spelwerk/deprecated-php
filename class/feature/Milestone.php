<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:35
 */

class Milestone {
    var $id, $canon, $name, $description, $icon;

    var $background;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $loyalty, $loyaltyOccupation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/milestone.png';

        $this->background = $data['background_id'];
        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];

        $this->loyalty = $data['loyalty_id'];
        $this->loyaltyOccupation = $data['loyalty_occupation'];

        $this->siteLink = '/content/milestone/id/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->formStart([
                'do' => 'basic--put',
                'return' => 'content/milestone',
                'context' => 'milestone',
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

        $component->returnButton('/content/milestone');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Background ID: '.$this->background); //todo api return name
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