<?php class Asset {
    var $id, $canon, $popularity, $name, $description, $price, $legal, $icon;

    var $type;

    var $group;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('asset/id/'.$id)['data'][0]
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

        $this->icon = $data['icon'];

        $this->type = $data['assettype_id'];
        $this->group = $data['assetgroup_id'];

        $this->siteLink = '/content/asset/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('asset', $this->id);
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/asset');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Legality: '.$this->legal);
        $component->p('Type ID: '.$this->type);
        $component->p('Group ID: '.$this->group);
        $component->h1('Attribute');
        $this->listAttribute();
        $component->h1('Doctrine');
        $this->listAttribute();
        $component->h1('Expertise');
        $this->listAttribute();
        $component->h1('Skill');
        $this->listSkill();

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/attribute/add','Add Attribute');
            $component->linkButton($this->siteLink.'/doctrine/add','Add Doctrine');
            $component->linkButton($this->siteLink.'/expertise/add','Add Expertise');
            $component->linkButton($this->siteLink.'/skill/add','Add Skill');
            $component->linkButton($this->siteLink.'/attribute/delete','Delete Attribute',true);
            $component->linkButton($this->siteLink.'/doctrine/delete','Delete Doctrine',true);
            $component->linkButton($this->siteLink.'/expertise/delete','Delete Expertise',true);
            $component->linkButton($this->siteLink.'/skill/delete','Delete Skill',true);
        }
    }

    public function delete() {} //todo

    // GET

    public function getAttribute() {
        global $system;

        return $system->getAttribute('asset/id/'.$this->id.'/attribute');
    }

    public function getDoctrine() {
        global $system;

        return $system->getAttribute('asset/id/'.$this->id.'/doctrine');
    }

    public function getExpertise() {
        global $system;

        return $system->getAttribute('asset/id/'.$this->id.'/expertise');
    }

    public function getSkill() {
        global $system;

        return $system->getSkill('asset/id/'.$this->id.'/skill');
    }

    // POST

    public function postAttribute() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'asset',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'content/asset'
        ]);

        $list = $curl->get('attribute')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your asset to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    public function postDoctrine() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'asset',
            'id' => $this->id,
            'context2' => 'doctrine',
            'return' => 'content/asset'
        ]);

        $list = $curl->get('doctrine')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Doctrine','Which Doctrine do you wish your asset to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    public function postExpertise() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'asset',
            'id' => $this->id,
            'context2' => 'expertise',
            'return' => 'content/asset'
        ]);

        $list = $curl->get('expertise')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Expertise do you wish your asset to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    public function postSkill() {
        if(!$this->verifyOwner()) exit;

        global $component, $form, $curl;

        $form->form([
            'do' => 'context--post',
            'context' => 'asset',
            'id' => $this->id,
            'context2' => 'skill',
            'return' => 'content/asset'
        ]);

        $list = $curl->get('skill')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Skill','Which Skill do you wish your asset to have extra value in?');
        $form->number(true,'value','Value',null,null,1,4,1);
        $component->wrapEnd();

        $form->submit();
    }

    // DELETE

    public function deleteAttribute() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('asset','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteDoctrine() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('asset','doctrine','delete',$this->id,$this->getDoctrine());
    }

    public function deleteExpertise() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('asset','expertise','delete',$this->id,$this->getExpertise());
    }

    public function deleteSkill() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('asset','skill','delete',$this->id,$this->getSkill());
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

    public function listDoctrine() {
        global $component;

        $list = $this->getDoctrine();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name.' ('.$item->value.')', $item->description, $item->icon);
            }
        }
    }

    public function listExpertise() {
        global $component;

        $list = $this->getExpertise();

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