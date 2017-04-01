<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 09:45
 */
class MenuTab {
    var $title, $listID, $icon, $active, $user, $admin;

    public function __construct($title, $listID, $icon, $active = false, $user = null, $admin = false) {
        $this->title = $title;
        $this->listID = $listID;
        $this->icon = $icon;
        $this->active = $active;
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build($user = null) {
        if($this->admin && $user && $user->admin || !$this->admin) {
            $class = $this->active
                ? 'sw-js-menu-tab sw-c-item--active'
                : 'sw-js-menu-tab sw-c-item';

            echo('<a class="'.$class.'" title="'.$this->title.'" id="tab__'.$this->listID.'"><img src="'.$this->icon.'"/></a>');
        }
    }
}