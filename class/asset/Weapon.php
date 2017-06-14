<?php class Weapon {
    var $id, $canon, $popularity, $name, $description, $icon, $price, $legal;

    var $damageD12, $damageBonus, $criticalD12, $hand, $initiative, $hit, $distance;

    var $special, $species, $augmentation;

    var $type, $group, $skill, $damage, $expertise;

    var $equipped;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('weapon/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];
        $this->icon = $data['icon'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->legal = $data['legal'];

        $this->damageD12 = isset($data['quality_damage_d12'])
            ? intval($data['damage_d12']) + intval($data['quality_damage_d12'])
            : intval($data['damage_d12']);

        $this->damageBonus = isset($data['quality_damage_bonus'])
            ? intval($data['damage_bonus']) + intval($data['quality_damage_bonus'])
            : intval($data['damage_bonus']);

        $this->criticalD12 = isset($data['quality_critical_d12'])
            ? intval($data['critical_d12']) + intval($data['quality_critical_d12'])
            : intval($data['critical_d12']);

        $this->hand = $data['hand'];

        $this->initiative = isset($data['quality_initiative'])
            ? intval($data['initiative']) + intval($data['quality_initiative'])
            : intval($data['initiative']);

        $this->hit = isset($data['quality_hit'])
            ? intval($data['hit']) + intval($data['quality_hit'])
            : intval($data['hit']);

        $this->distance = isset($data['quality_distance'])
            ? intval($data['distance']) + intval($data['quality_distance'])
            : intval($data['distance']);

        $this->type = $data['weapontype_id'];
        $this->group = $data['weapongroup_id'];

        $this->special = $data['special'];
        $this->species = $data['species'];
        $this->augmentation = $data['augmentation'];

        $this->skill = $data['skill_id'];
        $this->skillValue = isset($data['skill_value']) ? $data['skill_value'] : null;

        $this->expertise = $data['expertise_id'];
        $this->expertiseValue = isset($data['expertise_value']) ? $data['expertise_value'] : null;

        $this->damage = $data['damage_id'];

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : false;

        $this->siteLink = '/content/weapon/'.$this->id;
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}