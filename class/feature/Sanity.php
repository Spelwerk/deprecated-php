<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 19:41
 */
class Sanity {
    var $id, $canon, $name, $icon;

    var $heal, $lethal;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('sanity/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->icon = '/img/color/sanity.png';

        $this->heal = isset($data['heal'])
            ? $data['heal']
            : null;

        $this->double = isset($data['timestwo'])
            ? $data['timestwo']
            : null;

        $this->value = $this->double
            ? 2
            : 1;
    }
}