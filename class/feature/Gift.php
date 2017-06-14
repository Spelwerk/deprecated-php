<?php class Gift {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('gift/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/gift.png';

        $this->species = $data['species_id'];

        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];

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
        $component->p('Attribute ID: '.$this->attribute); //todo api return name
        $component->p('Attribute Value: '.$this->attributeValue); //todo api return name
        $component->p('Skill ID: '.$this->skill); //todo api return name
        $component->p('Skill Value: '.$this->skillValue); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }

    public function delete() {} //todo
}