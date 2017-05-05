<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:35
 */
class Weapon {

    var $id, $name, $description, $price, $special, $legal, $icon;

    var $damageD12, $damageBonus, $criticalD12, $hand, $initiative, $hit, $distance, $equipped;

    var $type, $group, $skill, $damage, $expertise;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('weapon/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->species = $data['species'];
        $this->augmentation = $data['augmentation'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->legal = $data['legal'];
        $this->icon = $data['icon'];

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

        $this->skill = $data['skill_id'];
        $this->skillValue = isset($data['skill_value']) ? $data['skill_value'] : null;

        $this->expertise = $data['expertise_id'];
        $this->expertiseLevel = isset($data['expertise_level']) ? $data['expertise_level'] : null;

        $this->damage = $data['damage_id'];

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : null;
    }
}