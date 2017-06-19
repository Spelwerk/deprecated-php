<?php class Imperfection {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $species;

    var $manifestation;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('imperfection/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = 'http://cdn.spelwerk.com/file/013eb6b688b6f622e1794f5b5422cc089eb8f67d.png';

        $this->species = $data['species_id'];

        $this->manifestation = $data['manifestation_id'];

        $this->siteLink = '/content/imperfection/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('imperfection', $this->id);
    }

    public function put() {
        if($this->verifyOwner()) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/imperfection',
                'context' => 'imperfection',
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

        $component->returnButton('/content/imperfection');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Species ID: '.$this->species); //todo api return name
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }

    public function delete() {} //todo
}