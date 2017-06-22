<?php class Augmentation {
    var $id, $canon, $popularity, $name, $description, $price, $legal, $icon;

    var $weapon;

    var $active;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('augmentation/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = $data['price'];
        $this->legal = $data['legal'];
        $this->weapon = $data['weapon_id'];
        $this->active = isset($data['active']) ? $data['active'] : false;
        $this->icon = $system->defaultIcon['augmentation'];

        $this->siteLink = '/content/augmentation/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('augmentation', $this->id);
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/augmentation');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Legality: '.$this->legal);
        $component->h1('Attribute');
        $this->listAttribute();
        $component->h1('Skill');
        $this->listSkill();

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/attribute/add','Add Attribute');
            $component->linkButton($this->siteLink.'/skill/add','Add Skill');
            $component->linkButton($this->siteLink.'/attribute/delete','Delete Attribute',true);
            $component->linkButton($this->siteLink.'/skill/delete','Delete Skill',true);
        }
    }

    public function delete() {} //todo

    // GET

    public function getAttribute() {
        global $system;

        return $system->getAttribute('augmentation/id/'.$this->id.'/attribute');
    }

    public function getSkill() {
        global $system;

        return $system->getSkill('augmentation/id/'.$this->id.'/skill');
    }

    // POST

    public function postAttribute() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl, $system;

        $form->form([
            'do' => 'context--post',
            'context' => 'augmentation',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'content/augmentation'
        ]);

        $list = $curl->get('attribute/special/0')['data'];
        $energy = $curl->get('attribute/id/'.$system->defaultAttributeId['energy'])['data'][0];

        $count = count($list) + 1;
        $list[$count] = $energy;

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your augmentation to have extra value in?');
        $form->number(true,'value','Value',null,null,null,12,1);
        $component->wrapEnd();

        $form->submit();
    }

    public function postSkill() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'augmentation',
            'id' => $this->id,
            'context2' => 'skill',
            'return' => 'content/augmentation'
        ]);

        $list = $curl->get('skill')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Skill','Which Skill do you wish your augmentation to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    // DELETE

    public function deleteAttribute() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('augmentation','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteSkill() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('augmentation','skill','delete',$this->id,$this->getSkill());
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