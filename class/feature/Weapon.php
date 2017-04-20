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

    var $type, $group, $skill, $quality, $damage, $expertise;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('weapon/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->special = $data['special'];
        $this->legal = $data['legal'];
        $this->icon = $data['icon_path'];

        $this->description = isset($data['weapon_custom'])
            ? $data['weapon_custom']
            : $data['description'];

        $this->hand = isset($data['hand'])
            ? $data['hand']
            : null;

        $this->icon = isset($data['icon_path'])
            ? $data['icon_path']
            : '/img/missing_icon.png';

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : null;

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->damageD12 = isset($data['quality_damage_d12'])
            ? intval($data['damage_d12']) + intval($data['quality_damage_d12'])
            : intval($data['damage_d12']);

        $this->damageBonus = isset($data['quality_damage_bonus'])
            ? intval($data['damage_bonus']) + intval($data['quality_damage_bonus'])
            : intval($data['damage_bonus']);

        $this->criticalD12 = isset($data['quality_critical_d12'])
            ? intval($data['critical_d12']) + intval($data['quality_critical_d12'])
            : intval($data['critical_d12']);

        $this->initiative = isset($data['quality_initiative'])
            ? intval($data['initiative']) + intval($data['quality_initiative'])
            : intval($data['initiative']);

        $this->hit = isset($data['quality_hit'])
            ? intval($data['hit']) + intval($data['quality_hit'])
            : intval($data['hit']);

        $this->distance = isset($data['quality_distance'])
            ? intval($data['distance']) + intval($data['quality_distance'])
            : intval($data['distance']);

        $this->type = [
            'id' => $data['weapontype_id'],
            'name' => $data['weapontype_name']
        ];

        $this->group = [
            'id' => $data['weapongroup_id'],
            'name' => $data['weapongroup_name']
        ];

        $this->skillValue = isset($data['skill_attribute_value'])
            ? $data['skill_attribute_value']
            : null;

        $this->expertiseLevel = isset($data['expertise_level'])
            ? $data['expertise_level']
            : null;

        if(isset($data['skill_attribute_id'])) {
            $this->skill = [
                'id' => $data['skill_attribute_id'],
                'name' => $data['skill_attribute_name']
            ];
        }

        if(isset($data['expertise_id'])) {
            $this->expertise = [
                'id' => $data['expertise_id'],
                'name' => $data['expertise_name']
            ];
        }

        if(isset($data['damage_attribute_id'])) {
            $this->damage = [
                'id' => $data['damage_attribute_id'],
                'name' => $data['damage_attribute_name'],
            ];
        }

        if(isset($data['quality_id'])) {
            $this->quality = [
                'id' => $data['quality_id'],
                'name' => $data['quality_name'],
            ];
        }
    }
}