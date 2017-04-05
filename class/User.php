<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-22
 * Time: 13:09
 */
class User {
    var $isActive, $isVerified, $isAdmin;

    var $id, $email, $displayname, $firstname, $surname, $token, $permissions;

    public function __construct() {
        global $curl;

        $this->token = isset($_COOKIE['sw_user_token'])
            ? $_COOKIE['sw_user_token']
            : null;

        $result = isset($this->token)
            ? $curl->get('user/token', $this->token)
            : null;

        $data = isset($result['user'])
            ? $result['user']
            : null;

        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->displayname = $data['displayname'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];

        $this->isActive = isset($this->token)
            ? true
            : false;

        $this->isAdmin = intval($data['admin']);
        $this->isVerified = intval($data['verified']);

        $this->permissions = $data['permissions'];
    }

    public function getPerson() {
        global $curl;

        $result = $curl->get('user-person/id/'.$this->id);

        $data = isset($result['data'])
            ? $result['data']
            : null;

        return $data;
    }

    public function getWorld() {
        global $curl;

        $result = $curl->get('user-world/id/'.$this->id);

        $data = isset($result['data'])
            ? $result['data']
            : null;

        return $data;
    }
}

