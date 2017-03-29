<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 16/02/2017
 * Time: 12:38
 */
class Protection {

    var $id, $name, $description, $price, $equipped, $icon;

    var $type, $bodypart, $attribute, $quality;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('protection/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->icon =  $data['icon_path'];

        $this->description = isset($data['protection_custom'])
            ? $data['protection_custom']
            : $data['description'];

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : null;

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->attributeId = $data['attribute_id'];
        $this->attributeValue = isset($data['quality_attribute_value'])
            ? intval($data['attribute_value']) + intval($data['quality_attribute_value'])
            : intval($data['attribute_value']);

        $this->type = [
            'id' => $data['protectiontype_id'],
            'name' => $data['protectiontype_name']
        ];

        $this->bodypart = [
            'id' => $data['bodypart_id'],
            'name' => $data['bodypart_name']
        ];

        $this->attribute = [
            'id' => $data['attribute_id'],
            'name' => $data['attribute_name']
        ];

        if(isset($data['quality_id'])) {
            $this->quality = [
                'id' => $data['quality_id'],
                'name' => $data['quality_name'],
            ];
        }
    }
}