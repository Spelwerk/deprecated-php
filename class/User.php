<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-22
 * Time: 13:09
 */
class User {
    var $id, $email, $username, $firstname, $surname, $token, $permissions;

    var $isAdmin, $isVerified;

    public function __construct($cookie = null) {
        global $curl;

        $this->token = $_COOKIE['sw_user_token'];

        $result = $curl->get('user/token', $this->token);

        $data = isset($result['user'])
            ? $result['user']
            : null;

        $this->id = intval($data['id']);
        $this->email = $data['email'];
        $this->username = $data['username'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];

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
}

