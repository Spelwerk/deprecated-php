<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-02
 * Time: 07:28
 */
class Bionic
{
    var $id, $name, $description, $legal, $price, $energy;

    var $attribute;

    var $bodypart;

    var $icon;

    var $augmentationList;

    public function __construct($array, $quality = null) {

        $this->id = $array['id'];

        $this->name = $array['name'];

        $this->description = $array['description'];

        $this->legal = $array['legal'];

        $price = intval($array['price']) * intval($array['quality_price']);

        $this->price = $price;

        $energy = intval($array['energy']) + intval($array['quality_energy']);

        $this->energy = $energy;

        $this->quality = [
            'id' => $array['quality_id'],
            'name' => $array['quality_name']
        ];

        $this->bodypart = [
            'id' => $array['bodypart_id'],
            'name' => $array['bodypart_name']
        ];

        $this->attribute = [
            'id' => $array['attribute_id'],
            'name' => $array['attribute_name'],
            'value' => $array['attribute_value']
        ];

        $this->icon = $array['icon_path'];
    }

    //todo function to add augmentation to bionic list
}