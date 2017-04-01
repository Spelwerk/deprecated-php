<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 09:53
 */
class MenuList {
    var $listID, $active;

    var $linkList;

    public function __construct($listID, $active = false) {
        $this->listID = $listID;
        $this->active = $active;
    }

    public function add($title, $href, $active = false, $admin = false) {
        $this->linkList[] = new MenuLink($title, $href, $active, $admin);
    }

    public function build($user = null) {
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