<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-03
 * Time: 15:09
 */
class Background {

    var $id, $name, $description, $icon;

    // todo background has attribute

    // todo background has asset

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('background/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->icon = $data['icon_path'];

        $this->description = isset($data['background_custom'])
            ? $data['background_custom']
            : $data['description'];
    }
}