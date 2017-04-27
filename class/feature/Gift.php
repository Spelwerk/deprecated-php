<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:11
 */
class Gift {

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('gift/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];

        $this->icon = '/img/person/characteristic-gift.png';

        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        if(isset($data['species_id'])) {
            $this->species = [
                'id' => $data['species_id'],
                'name' => $data['species_name']
            ];
        }

        if(isset($data['manifestation_id'])) {
            $this->manifestation = [
                'id' => $data['manifestation_id'],
                'name' => $data['manifestation_name']
            ];
        }

        $this->attribute = $data['attribute_id'];
    }
}