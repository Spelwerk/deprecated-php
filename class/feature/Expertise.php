<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:15
 */

class Expertise {
    var $id, $canon, $name, $description, $icon;

    var $value, $bonus;

    var $required, $increment, $maximum;

    var $skill;

    var $species;

    var $manifestation;

    var $doctrine;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('expertise/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $defaults = $curl->get('system/expertise');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->value = isset($data['value']) ? $data['value'] : null;
        $this->bonus = isset($data['bonus']) ? $data['bonus'] : null;

        $this->maximum = $defaults['maximum'];

        $this->skill = $data['skill_id'];
        $this->skillName = isset($data['skill_name']) ? $data['skill_name'] : null;
        $this->species = $data['species_id'];
        $this->speciesName = isset($data['species_name']) ? $data['species_name'] : null;
        $this->manifestation = $data['manifestation_id'];
        $this->manifestationName = isset($data['manifestation_name']) ? $data['manifestation_name'] : null;
        $this->doctrine = $data['doctrine_id'];

        $this->dice = intval($this->start) + intval($this->value) - 1;

        $this->siteLink = '/content/expertise/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/expertise',
                'context' => 'expertise',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $component->wrapEnd();
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/expertise');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Skill: '.$this->skillName);
        $component->p('Species: '.$this->speciesName);
        $component->p('Manifestation: '.$this->manifestationName);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }
}