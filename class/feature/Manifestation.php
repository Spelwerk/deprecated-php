<?php class Manifestation {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $power;

    var $skill;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('manifestation/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->power = $data['power_id'];

        $this->skill = $data['skill_id'];

        $this->siteLink = '/content/manifestation/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('manifestation', $this->id);
    }

    public function put() {
        if($this->verifyOwner()) {
            global $form, $component;

            $form->form([
                'do' => 'put',
                'return' => 'content/manifestation',
                'context' => 'manifestation',
                'id' => $this->id
            ]);

            $component->wrapStart();
            $form->varchar(true, 'name', 'Name', null, null, $this->name);
            $form->text(false, 'description', 'Description', null, null, $this->description);
            $form->icon();
            $component->wrapEnd();

            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/manifestation');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Power ID: '.$this->power); //todo api return name
        $component->p('Skill ID: '.$this->skill); //todo api return name
        $component->h1('Focus');
        $this->listFocus();
        $component->h1('Doctrine');
        $this->listDoctrine();

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/doctrine/add','Add Doctrine');
            $component->linkButton($this->siteLink.'/focus/add','Add Focus');
            $component->linkButton($this->siteLink.'/doctrine/delete','Delete Doctrine',true);
            $component->linkButton($this->siteLink.'/focus/delete','Delete Focus',true);

            $component->h2('Create');
            $component->linkButton($this->siteLink.'/background','Create Background');
            $component->linkButton($this->siteLink.'/gift','Create Gift');
            $component->linkButton($this->siteLink.'/imperfection','Create Imperfection');
            $component->linkButton($this->siteLink.'/milestone','Create Milestone');
        }
    }

    public function delete() {} //todo

    // GET

    public function getDoctrine() {
        global $system;

        return $system->getDoctrine('doctrine/manifestation/'.$this->id);
    }

    public function getExpertise($override = null) {
        global $system;

        $get = isset($override)
            ? $override
            : 'expertise/manifestation/'.$this->id;

        return $system->getExpertise($get);
    }

    public function getFocus() {
        global $system;

        return $system->getFocus('focus/manifestation/'.$this->id);
    }

    // POST

    public function postBackground() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->createBackground(null, $this->id);
    }

    public function postDoctrine() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->postDoctrine($this->id);
    }

    public function postFocus() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->postFocus($this->id);
    }

    public function postGift() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->createGift(null, $this->id);
    }

    public function postImperfection() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->createImperfection(null, $this->id);
    }

    public function postMilestone() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->createMilestone(null, null, $this->id);
    }

    // DELETE

    public function deleteDoctrine() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('manifestation', 'doctrine', 'delete', $this->id, $this->getDoctrine());
    }

    public function deleteFocus() {
        if(!$this->verifyOwner()) exit;

        global $system;

        $system->contentSelectList('manifestation', 'focus', 'delete', $this->id, $this->getFocus());
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
    }

    public function listFocus() {
        global $component;

        $list = $this->getFocus();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }
    }
}