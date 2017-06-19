<?php class WeaponGroup {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $special;

    var $skill, $damage, $expertise;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('weapongroup/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->special = $data['special'];

        $this->skill = $data['skill_id'];
        $this->expertise = $data['expertise_id'];
        $this->damage = $data['damage_id'];

        $this->siteLink = '/content/weapongroup/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('weapongroup', $this->id);
    }

    public function put() {
        if($this->verifyOwner()) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'id' => $this->id,
                'context' => 'weapongroup',
                'return' => 'content/weapongroup'
            ]);
            $component->wrapStart();
            $form->varchar(true, 'name', 'Name', null, null, $this->name);
            $form->text(false, 'description', 'Description', null, null, $this->description);
            $form->icon();
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/weapongroup');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');

        $component->p('Skill ID: '.$this->skill);
        $component->p('Damage ID: '.$this->damage);
        $component->p('Expertise ID: '.$this->expertise);

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}