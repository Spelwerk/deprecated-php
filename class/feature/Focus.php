<?php class Focus {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $manifestation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('focus/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('focus',$this->id);

        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->manifestation = $data['manifestation_id'];

        $this->siteLink = '/content/focus/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'context' => 'focus',
                'id' => $this->id,
                'return' => 'content/focus'
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

        $component->returnButton('/content/focus');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }
}