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

        $this->siteLink = '/content/manifestation/id/'.$this->id;
    }

    public function put() {
        global $form, $component;

        $form->formStart([
            'do' => 'basic--put',
            'return' => 'content/manifestation',
            'context' => 'manifestation',
            'id' => $this->id
        ]);

        $component->wrapStart();
        $form->varchar(true,'name','Name',null,null,$this->name);
        $form->text(false,'description','Description',null,null,$this->description);
        $component->wrapEnd();

        $form->formEnd();
    }

    public function view() {
        global $component;

        $component->returnButton('/content/manifestation');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Power ID: '.$this->power); //todo api return name
        $component->p('Skill ID: '.$this->skill); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/doctrine','Doctrine');
            $component->linkButton($this->siteLink.'/focus','Focus');

            $component->h2('Create');
            $component->linkButton($this->siteLink.'/background','Create Background');
            $component->linkButton($this->siteLink.'/gift','Create Gift');
            $component->linkButton($this->siteLink.'/imperfection','Create Imperfection');
            $component->linkButton($this->siteLink.'/milestone','Create Milestone');
        }
    }

    // GET

    public function getDoctrine() {
        global $system;

        return $system->getDoctrine('/manifestation/'.$this->id);
    }

    public function getFocus() {
        global $system;

        return $system->getFocus('/manifestation/'.$this->id);
    }

    // POST

    public function postBackground() {
        global $system;

        $system->createBackground(null,$this->id);
    }

    public function postDoctrine() {
        global $component, $form;

        $component->h1('Create Doctrine');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/manifestation',
            'returnafter' => 'doctrine',
            'context' => 'doctrine'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        $form->hidden('manifestation_id',$this->id);

        $form->formEnd();
    }

    public function postFocus() {
        global $curl, $component, $form;

        $component->h1('Create Focus');

        $attributeList = $curl->get('attribute/special/0')['data'];

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/manifestation',
            'returnafter' => 'focus',
            'context' => 'focus'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->select(false,'attribute_id',$attributeList,'Attribute','If this gift increases an attribute, which one?');
        $form->number(false,'attribute_value','Attribute Value','Amount of points this gift will increase by.',null,0,16);
        $component->wrapEnd();

        $form->hidden('manifestation_id',$this->id);

        $form->formEnd();
    }

    public function postGift() {
        global $system;

        $system->createGift(null,$this->id);
    }

    public function postImperfection() {
        global $system;

        $system->createImperfection(null,$this->id);
    }

    public function postMilestone() {
        global $system;

        $system->createMilestone(null,null,$this->id);
    }

    // DELETE

    public function deleteDoctrine() {
        global $system;

        $system->contentSelectList('manifestation','doctrine','delete',$this->id,$this->getDoctrine());
    }

    public function deleteFocus() {
        global $system;

        $system->contentSelectList('manifestation','focus','delete',$this->id,$this->getFocus());
    }

    // LIST

    public function listDoctrine() {
        global $component;

        $list = $this->getDoctrine();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        $component->linkButton($this->siteLink.'/doctrine/add','Add');
        $component->linkButton($this->siteLink.'/doctrine/delete','Delete',true);
    }

    public function listFocus() {
        global $component;

        $list = $this->getFocus();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        $component->linkButton($this->siteLink.'/focus/add','Add');
        $component->linkButton($this->siteLink.'/focus/delete','Delete',true);
    }
}