<?php class WeaponType {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $special;

    var $damageD12, $criticalD12;

    var $hand, $initiative, $hit, $distance;

    var $group, $skill, $damage, $expertise;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('weapontype/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->damageD12 = intval($data['damage_d12']);
        $this->criticalD12 = intval($data['critical_d12']);
        $this->hand = intval($data['hand']);
        $this->initiative = intval($data['initiative']);
        $this->hit = intval($data['hit']);
        $this->distance = intval($data['distance']);

        $this->group = $data['weapongroup_id'];

        $this->special = $data['special'];

        $this->skill = $data['skill_id'];
        $this->expertise = $data['expertise_id'];
        $this->damage = $data['damage_id'];

        $this->siteLink = '/content/weapontype/'.$this->id;
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}