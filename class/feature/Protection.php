<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 16/02/2017
 * Time: 12:38
 */

class Protection {
    var $id, $canon, $name, $description, $price, $icon;

    var $bodypart;

    var $equipped;

    var $quality, $bonus;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('protection/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->icon =  $data['icon'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->bodypart = $data['bodypart_id'];

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : null;

        $this->quality = $data['quality_id'];
    }
}