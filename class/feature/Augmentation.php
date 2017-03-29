<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 14:33
 */
class Augmentation {

    var $id, $name, $description, $legal, $price, $energy, $icon;

    var $bionic, $attribute, $quality, $weapon;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('bionic/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->legal = $data['legal'];
        $this->icon = 'http://cdn.spelwerk.com/file/2caee0a3adc7b135ffdd111fc150fb36442ffaa7.png';

        $this->description = isset($data['augmentation_custom']) && $data['augmentation_custom'] != null
            ? $data['augmentation_custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->energy = isset($data['quality_energy'])
            ? intval($data['energy']) * intval($data['quality_energy'])
            : intval($data['energy']);

        $this->bionicId = $data['bionic_id'];
        $this->bionicName = $data['bionic_name'];

        $this->bionic = [
            'id' => $data['bionic_id'],
            'name' => $data['bionic_name']
        ];

        $this->attribute = [
            'id' => $data['attribute_id'],
            'name' => $data['attribute_name'],
            'value' => $data['attribute_value']
        ];

        $this->weapon = [
            'id' => $data['weapon_id'],
            'name' => $data['weapon_name']
        ];

        if(isset($data['quality_id'])) {
            $this->quality = [
                'id' => $data['quality_id'],
                'name' => $data['quality_name'],
            ];
        }
    }
}