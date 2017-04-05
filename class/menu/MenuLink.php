<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 10:08
 */
class MenuLink {
    var $title, $href, $active, $user, $admin;

    var $linkList;

    public function __construct($title, $href, $user = false, $admin = false) {
        $this->title = $title;
        $this->href = $href;
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build($user) {
        if($this->user && !$user->isActive) {}
        else if($this->admin && !$user->isActive) {}
        else if($this->user && $user->isActive && !$user->isVerified) {}
        else if($this->admin && $user->isActive && !$user->isAdmin) {}
        else {
            $class = $this->active
                ? 'sw-js-menu-link sw-c-item--active'
                : 'sw-js-menu-link sw-c-item';

            echo('<a class="'.$class.'" href="'.$this->href.'" title="'.$this->title.'">'.$this->title.'</a>');
        }
    }
}