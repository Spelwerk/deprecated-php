<?php

class Species {

    var $id, $canon, $playable, $name, $description, $icon;

    var $maxAge, $multiplySkill, $multiplyExpertise;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('species/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->playable = $data['playable'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->maxAge = $data['max_age'];
        $this->multiplySkill = intval($data['multiply_skill']);
        $this->multiplyExpertise = intval($data['multiply_expertise']);

        $this->siteLink = '/content/species/'.$this->id;
    }

    public function put() {
        global $form, $component;

        $form->formStart([
            'do' => 'species--put',
            'return' => 'content/species/id',
            'id' => $this->id
        ]);

        $component->h2('Basic Information');
        $component->wrapStart();
        $form->varchar(true,'name','Name',null,null,$this->name);
        $form->text(false,'description','Description',null,null,$this->description);
        $form->number(false,'max_age','Maximum Age','What is the maximum age your species can live?',null,1,12,$this->maxAge);
        $component->wrapEnd();

        $component->h2('Multiplication');
        $component->subtitle('During person/character creation, a person will multiply age with a value to receive points. With what value? This is useful for species that won\'t live long, but mature quickly.');
        $component->wrapStart();
        $form->number(false,'multiply_skill','Multiplying Skill','Increase this if your species should receive bonuses to skill',null,1,16,$this->multiplySkill);
        $form->number(false,'multiply_expertise','Multiplying Expertise','Increase this if your species should receive bonuses to expertises',null,1,16,$this->multiplyExpertise);
        $component->wrapEnd();

        $form->formEnd();
    }

    public function view() {
        global $component;

        $component->returnButton('/content/species');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Maximum Age: '.$this->maxAge);
        $component->p('Multiply Skill: '.$this->multiplySkill);
        $component->p('Multiply Expertise: '.$this->multiplyExpertise);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/attribute','Add Attribute');
            //$component->linkButton($species->siteLink.'/skill','Skill');
            //$component->linkButton($species->siteLink.'/expertise','Expertise');
            //$component->linkButton($species->siteLink.'/weapon','Weapon');
        }
    }

    // GET

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'species/id/'.$this->id.'/attribute'.$override
            : 'species/id/'.$this->id.'/attribute';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBackground() {
        global $system;

        return $system->getBackground('/species/'.$this->id);
    }

    public function getExpertise() {
        global $system;

        return $system->getExpertise('/species/'.$this->id);
    }

    public function getGift() {
        global $system;

        return $system->getGift('/species/'.$this->id);
    }

    public function getImperfection() {
        global $system;

        return $system->getImperfection('/species/'.$this->id);
    }

    public function getMilestone() {
        global $system;

        return $system->getMilestone('/species/'.$this->id);
    }

    public function getSkill() {
        global $system;

        return $system->getSkill('/species/'.$this->id);
    }

    public function getWeapon() {
        global $curl;

        $result = $curl->get('species/id/'.$this->id.'/weapon')['data'];

        $data = isset($result)
            ? $result
            : null;

        return $data;
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $component->h1('Add Attribute');
        $form->formStart([
            'do' => 'basic--has--value',
            'return' => 'content/species',
            'returnafter' => 'attribute',
            'context' => 'species',
            'context2' => 'attribute',
            'id' => $this->id
        ]);

        $list = $curl->get('attribute/special/0')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your species to have extra value in?');
        $form->number(true,'value','Value',null,null,1,8,1);
        $component->wrapEnd();

        $form->formEnd();
    }

    public function postExpertise() {} // todo create expertise in created skill specific for species

    public function postGift() {} // todo create gift specific for species

    public function postImperfection() {} // todo create imperfection specific for species

    public function postMilestone() {} // todo create milestone specific for species

    public function postSkill() {} // todo create skill specific for species

    public function postWeapon() {} // todo create weaponry specific for species

    // DELETE

    public function deleteAttribute() {
        global $system;

        $system->contentSelectList('species','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteExpertise() {} // todo

    public function deleteSkill() {} // todo

    public function deleteWeapon() {
        global $system;

        $system->contentSelectList('species','weapon','delete',$this->id,$this->getWeapon());
    }

    // LIST

    public function listAttribute() {
        global $component;

        $list = $this->getAttribute();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name.' ('.$item->value.')', $item->description, $item->icon);
            }
        }

        $component->linkButton($this->siteLink.'/attribute/add','Add');
        $component->linkButton($this->siteLink.'/attribute/delete','Delete',true);
    }
}