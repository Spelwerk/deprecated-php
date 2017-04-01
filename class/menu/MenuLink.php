<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 10:08
 */
class MenuLink {
    var $title, $href, $active, $admin;

    var $linkList;

    public function __construct($title, $href, $active = false, $admin = false) {
        $this->title = $title;
        $this->href = $href;
        $this->active = $active;
        $this->admin = $admin;
    }

    public function build($user) {
        $class = $this->active
            ? 'sw-js-menu-link sw-c-item--active'
            : 'sw-js-menu-link sw-c-item';

        if(($this->admin && $user && $user->admin) || !$this->admin) {
            echo('<a class="'.$class.'" href="'.$this->href.'" title="'.$this->title.'">'.$this->title.'</a>');
        }
    }
}