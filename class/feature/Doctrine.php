<?php class Doctrine {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $manifestation;

    var $value;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('doctrine/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('doctrine',$this->id);

        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $system->defaultDoctrine['maximum'];

        $this->manifestation = $data['manifestation_id'];
        $this->expertise = $data['expertise_id'];

        $this->value = isset($data['value']) ? $data['value'] : 0;

        $this->dice = intval($this->value);
        $this->diceText = $this->value.'d'.$system->defaultDice['value'];

        $this->siteLink = '/content/doctrine/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $component->h1('Edit Doctrine');

            $form->form([
                'do' => 'put',
                'context' => 'doctrine',
                'id' => $this->id,
                'return' => 'content/doctrine'
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

        $component->returnButton('/content/doctrine');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}