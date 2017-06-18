<?php class Attribute {
    var $id, $canon, $name, $description, $icon;

    var $type, $maximum;

    var $value;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $user;

        $this->isOwner = $user->isAdmin;

        $data = isset($id)
            ? $curl->get('attribute/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->type = isset($data['attributetype_id']) ? $data['attributetype_id'] : null;
        $this->maximum = isset($data['maximum']) ? $data['maximum'] : 0;

        $this->value = isset($data['value']) ? $data['value'] : 0;

        $this->siteLink = '/content/attribute/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'context' => 'attribute',
                'id' => $this->id,
                'return' => 'content/attribute'
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

        $component->returnButton('/content/attribute');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Type: '.$this->type);
        $component->p('Maximum: '.$this->maximum);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }
}