<?php class Milestone {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $background;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $loyalty, $loyaltyOccupation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->popularity = $data['popularity'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = 'http://cdn.spelwerk.com/file/f0ba5d18c543b0a767832c0be49a96503fc8f75d.png';

        $this->background = $data['background_id'];
        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->siteLink = '/content/milestone/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/milestone',
                'context' => 'milestone',
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

        $component->returnButton('/content/milestone');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Background ID: '.$this->background); //todo api return name
        $component->p('Species ID: '.$this->species); //todo api return name
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name
        $component->h1('Attribute');
        $this->listAttribute();
        $component->h1('Skill');
        $this->listSkill();

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/attribute/add','Add Attribute');
            $component->linkButton($this->siteLink.'/skill/add','Add Skill');
            $component->linkButton($this->siteLink.'/attribute/delete','Delete Attribute',true);
            $component->linkButton($this->siteLink.'/skill/delete','Delete Skill',true);
            //todo link to delete();
        }
    }

    public function delete() {} //todo

    // GET

    public function getAttribute($override = null) {
        global $system;

        $get = isset($override)
            ? 'milestone/id/'.$this->id.'/attribute'.$override
            : 'milestone/id/'.$this->id.'/attribute';

        return $system->getAttribute($get);
    }

    public function getSkill($override = null) {
        global $system;

        $get = isset($override)
            ? 'milestone/id/'.$this->id.'/skill'.$override
            : 'milestone/id/'.$this->id.'/skill';

        return $system->getSkill($get);
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'milestone',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'content/milestone'
        ]);

        $list = $curl->get('attribute/special/0')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your milestone to have extra value in?');
        $form->number(true,'value','Value',null,null,-16,16,1);
        $component->wrapEnd();

        $form->submit();
    }

    public function postMilestone() {
        global $system;

        $system->createMilestone($this->id);
    }

    public function postSkill() {
        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'milestone',
            'id' => $this->id,
            'context2' => 'skill',
            'return' => 'content/milestone'
        ]);

        $list = $curl->get('skill')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Skill','Which Skill do you wish your milestone to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    // DELETE

    public function deleteAttribute() {
        global $system;

        $system->contentSelectList('milestone','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteSkill() {
        global $system;

        $system->contentSelectList('milestone','skill','delete',$this->id,$this->getSkill());
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
    }

    public function listSkill() {
        global $component;

        $list = $this->getSkill();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name.' ('.$item->value.')', $item->description, $item->icon);
            }
        }
    }
}