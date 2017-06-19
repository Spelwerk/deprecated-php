<?php class Background {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $species;

    var $manifestation;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('background/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->siteLink = '/content/background/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('background', $this->id);
    }

    public function put() {
        if($this->verifyOwner()) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/background',
                'context' => 'background',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $form->icon();
            $component->wrapEnd();
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/background');

        if($this->icon) $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name
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

            $component->h2('Create');
            $component->linkButton($this->siteLink.'/milestone','Create Milestone',false,'sw-is-green');
        }
    }

    public function delete() {} //todo

    // GET

    public function getAttribute($override = null) {
        global $system;

        $get = isset($override)
            ? 'background/id/'.$this->id.'/attribute'.$override
            : 'background/id/'.$this->id.'/attribute';

        return $system->getAttribute($get);
    }

    public function getSkill($override = null) {
        global $system;

        $get = isset($override)
            ? 'background/id/'.$this->id.'/skill'.$override
            : 'background/id/'.$this->id.'/skill';

        return $system->getSkill($get);
    }

    // POST

    public function postAttribute() {
        if($this->verifyOwner()) {
            global $component, $form, $curl;

            $form->form([
                'do' => 'context--post',
                'context' => 'background',
                'id' => $this->id,
                'context2' => 'attribute',
                'return' => 'content/background'
            ]);

            $list = $curl->get('attribute/special/0')['data'];

            $component->wrapStart();
            $form->select(true, 'insert_id', $list, 'Attribute', 'Which Attribute do you wish your background to have extra value in?');
            $form->number(true, 'value', 'Value', null, null, 1, 4, 1);
            $component->wrapEnd();

            $form->submit();
        }
    }

    public function postMilestone() {
        if($this->verifyOwner()) {
            global $system;

            $system->createMilestone($this->id);
        }
    }

    public function postSkill() {
        if($this->verifyOwner()) {
            global $component, $form, $curl;

            $form->form([
                'do' => 'context--post',
                'context' => 'background',
                'id' => $this->id,
                'context2' => 'skill',
                'return' => 'content/background'
            ]);

            $list = $curl->get('skill')['data'];

            $component->wrapStart();
            $form->select(true, 'insert_id', $list, 'Skill', 'Which Skill do you wish your background to have extra value in?');
            $form->number(true, 'value', 'Value', null, null, 1, 4, 1);
            $component->wrapEnd();

            $form->submit();
        }
    }

    // DELETE

    public function deleteAttribute() {
        if($this->verifyOwner()) {
            global $system;

            $system->contentSelectList('background', 'attribute', 'delete', $this->id, $this->getAttribute());
        }
    }

    public function deleteSkill() {
        if($this->verifyOwner()) {
            global $system;

            $system->contentSelectList('background', 'skill', 'delete', $this->id, $this->getSkill());
        }
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