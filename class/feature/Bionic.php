<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-02
 * Time: 07:28
 */
class Bionic
{
    var $id, $name, $description, $legal, $price, $energy, $icon;

    var $bodypart, $attribute, $quality;

    public function __construct($id = null, $array = null, $quality = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('bionic/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->legal = $data['legal'];
        $this->icon = $data['icon_path'];

        $this->description = isset($data['bionic_custom'])
            ? $data['bionic_custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->energy = isset($data['quality_energy'])
            ? intval($data['energy']) * intval($data['quality_energy'])
            : intval($data['energy']);

        $this->bodypart = [
            'id' => $data['bodypart_id'],
            'name' => $data['bodypart_name']
        ];

        $this->attribute = [
            'id' => $data['attribute_id'],
            'name' => $data['attribute_name'],
            'value' => $data['attribute_value']
        ];

        if(isset($data['quality_id'])) {
            $this->quality = [
                'id' => $data['quality_id'],
                'name' => $data['quality_name'],
            ];
        }
    }
}