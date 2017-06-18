<?php class Identity {
    var $id, $name, $description, $icon;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $user;

        $this->isOwner = $user->isAdmin;

        $data = isset($id)
            ? $curl->get('identity/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->siteLink = '/content/identity/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'context' => 'identity',
                'id' => $this->id,
                'return' => 'content/identity'
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

        $component->returnButton('/content/identity');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }
}