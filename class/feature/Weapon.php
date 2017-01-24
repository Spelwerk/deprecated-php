<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 17:35
 */
class Weapon {

    var $id, $name, $description, $price, $hidden, $legal;

    var $equipped;

    var $type, $group, $skill, $quality, $damage, $expertise;

    var $icon;

    public function __construct($array) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $price = intval($array['price']) * intval($array['quality_price']);

        $this->price = $price;

        $this->hidden = $array['hidden'];

        $this->legal = $array['legal'];

        $this->equipped = $array['equipped'];

        $this->type = [
            'id' => $array['weapontype_id'],
            'name' => $array['weapontype_name']
        ];

        $this->group = [
            'id' => $array['weapongroup_id'],
            'name' => $array['weapongroup_name']
        ];

        $this->skill = [
            'id' => $array['skill_attribute_id'],
            'name' => $array['skill_attribute_name']
        ];

        $this->quality = [
            'id' => $array['quality_id'],
            'name' => $array['quality_name']
        ];

        $damage_d12 = intval($array['damage_d12']) + intval($array['quality_damage_d12']);
        $damage_bonus = intval($array['damage_bonus']) + intval($array['quality_damage_bonus']);
        $critical_d12 = intval($array['critical_d12']) + intval($array['quality_critical_d12']);
        $hand = intval($array['hand']);
        $initiative = intval($array['initiative']) + intval($array['quality_initiative']);
        $hit = intval($array['hit']) + intval($array['quality_hit']);
        $distance = intval($array['distance']) + intval($array['quality_distance']);

        $this->damage = [
            'id' => $array['damage_attribute_id'],
            'name' => $array['damage_attribute_name'],
            'damage_d12' => $damage_d12,
            'damage_bonus' => $damage_bonus,
            'critical_d12' => $critical_d12,
            'hand' => $hand,
            'initiative' => $initiative,
            'hit' => $hit,
            'distance' => $distance
        ];

        $this->expertise = [
            'id' => $array['expertise_id'],
            'name' => $array['expertise_name']
        ];

        $this->icon = $array['icon_path'];

    }

}