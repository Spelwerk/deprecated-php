<?php class WeaponGroup {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $special;

    var $skill, $damage, $expertise;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('weapongroup/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

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

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}