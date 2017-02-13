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

    public function __construct($cookie) {
        global $curl;

        $this->token = $_COOKIE['sw_user_token'];

        $data = $curl->get('user/token',$this->token)['user'];

        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->username = $data['username'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];

        $this->isAdmin = $data['admin'];
        $this->isVerified = $data['verified'];

        $this->permissions = $data['permissions'];
    }
}