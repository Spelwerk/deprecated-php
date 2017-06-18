<?php class Gift {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $species;

    var $manifestation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('gift/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('gift',$this->id);

        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = 'http://cdn.spelwerk.com/file/9224721c30565571fa737c6309630f11285d50d4.png';

        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->siteLink = '/content/gift/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/gift',
                'context' => 'gift',
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

        $component->returnButton('/content/gift');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
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
            ? 'gift/id/'.$this->id.'/attribute'.$override
            : 'gift/id/'.$this->id.'/attribute';

        return $system->getAttribute($get);
    }

    public function getSkill($override = null) {
        global $system;

        $get = isset($override)
            ? 'gift/id/'.$this->id.'/skill'.$override
            : 'gift/id/'.$this->id.'/skill';

        return $system->getSkill($get);
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'gift',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'content/gift'
        ]);

        $list = $curl->get('attribute/special/0')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your gift to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
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
            'context' => 'gift',
            'id' => $this->id,
            'context2' => 'skill',
            'return' => 'content/gift'
        ]);

        $list = $curl->get('skill')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Skill','Which Skill do you wish your gift to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    // DELETE

    public function deleteAttribute() {
        global $system;

        $system->contentSelectList('gift','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteSkill() {
        global $system;

        $system->contentSelectList('gift','skill','delete',$this->id,$this->getSkill());
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