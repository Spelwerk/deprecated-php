<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-25
 * Time: 21:20
 */
class Imperfection {

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('imperfection/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];

        $this->icon = '/img/person/characteristic-imperfection.png';

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
    }
}