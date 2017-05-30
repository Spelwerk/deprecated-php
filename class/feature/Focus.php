<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:37
 */

class Focus {

    var $id, $canon, $name, $description, $icon;

    var $manifestation;

    var $attribute, $attributeValue;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('focus/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->siteLink = '/content/focus/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->formStart([
                'do' => 'basic--put',
                'return' => 'content/focus',
                'context' => 'focus',
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

        $component->returnButton('/content/focus');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name
        $component->p('Attribute ID: '.$this->attribute); //todo api return name
        $component->p('Attribute Value: '.$this->attributeValue); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }
}