<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 19:41
 */
class Sanity {

    var $id, $name, $popularity, $hidden, $aid, $heal, $lethal, $icon;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('wound/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];

        $this->popularity = isset($data['popularity'])
            ? $data['popularity']
            : null;

        $this->hidden = isset($data['hidden'])
            ? $data['hidden']
            : null;

        $this->heal = isset($data['heal'])
            ? $data['heal']
            : null;

        $this->double = isset($data['timestwo'])
            ? $data['timestwo']
            : null;

        $this->value = $this->double
            ? 2
            : 1;

        $this->icon = '/img/color/sanity.png';
    }

}