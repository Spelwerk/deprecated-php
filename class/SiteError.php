<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 13/02/2017
 * Time: 09:19
 */
class SiteError {

    var $id, $header, $description, $action;

    public function __construct($id = null) {
        $this->id = isset($id)
            ? $id
            : 0;

        $this->switchError($this->id);
    }

    function switchError($id) {
        switch($id)
        {
            default:
                $this->header = 'Unknown Error';
                $this->description = 'We could not figure out what went wrong but it did.';
                break;
        }
    }
}