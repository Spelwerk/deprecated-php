<?php class Skill {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $species;

    var $value;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('skill/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $defaults = $curl->get('system/skill');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $defaults['maximum'];
        $this->required = $defaults['required'];
        $this->increment = $defaults['increment'];

        $this->species = $data['species_id'];

        $this->value = isset($data['value']) ? intval($data['value']) : 0;

        $this->siteLink = '/content/skill/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/skill',
                'context' => 'skill',
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

        $component->returnButton('/content/skill');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }

    public function delete() {} //todo
}