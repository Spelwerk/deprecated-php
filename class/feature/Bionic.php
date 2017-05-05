<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-02
 * Time: 07:28
 */

class Bionic {
    var $id, $canon, $name, $description, $price, $energy, $legal, $icon;

    var $bodypart;

    var $attribute, $attributeValue;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('bionic/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->energy = isset($data['quality_energy'])
            ? intval($data['energy']) * intval($data['quality_energy'])
            : intval($data['energy']);

        $this->legal = $data['legal'];
        $this->icon = $data['icon'];

        $this->bodypart = $data['bodypart_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];
    }
}

// todo has augmentation