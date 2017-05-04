<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-05-04
 * Time: 17:32
 */

class Doctrine {
    var $id, $canon, $name, $description, $icon;

    var $manifestation;

    var $value;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('doctrine/id/'.$id)['data'][0]
            : $array;

        $defaults = $curl->get('system/doctrine');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $defaults['maximum'];

        $this->manifestation = $data['manifestation_id'];

        $this->value = $data['value'];
    }
}