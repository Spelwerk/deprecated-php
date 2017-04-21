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
        global $curl, $cookieArray;

        $this->token = isset($_COOKIE[$cookieArray['token']])
            ? $_COOKIE[$cookieArray['token']]
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

    public function getStory() {
        global $curl;

        $result = $curl->get('user-story/id/'.$this->id);

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

