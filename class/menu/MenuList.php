<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 09:53
 */
class MenuList {
    var $listID, $active, $user, $admin;

    var $linkList;

    public function __construct($listID, $user = false, $admin = false) {
        $this->listID = $listID;
        $this->user = $user;
        $this->admin = $admin;
    }

    public function add($title, $href, $user = false, $admin = false) {
        $this->linkList[] = new MenuLink($title, $href, $user, $admin);
    }

    public function build($user) {
        if($this->user && !$user->isActive) {}
        else if($this->admin && !$user->isActive) {}
        else if($this->user && $user->isActive && !$user->isVerified) {}
        else if($this->admin && $user->isActive && !$user->isAdmin) {}
        else {
            $class = $this->active
                ? 'sw-js-menu-links sw-c-links'
                : 'sw-js-menu-links sw-c-links sw-is-hidden';

            echo('<nav class="'.$class.'" id="list__'.$this->listID.'">');

            foreach($this->linkList as $link) {
                $link->build($user);
            }

            echo('</nav>');
        }
    }
}