<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 30/03/2017
 * Time: 09:44
 */
require_once('menu/MenuTab.php');
require_once('menu/MenuList.php');
require_once('menu/MenuLink.php');

class Menu {
    var $user;
    var $tabArray;
    var $listArray;

    public function __construct($user = null) {
        $this->user = $user;
        $this->tabArray = [];
        $this->listArray = [];
    }

    public function addTab($title, $listID, $icon, $active = false, $user = null, $admin = false) {
        $this->tabArray[] = new MenuTab($title, $listID, $icon, $active, $user, $admin);
    }

    public function addList($linkList) {
        $this->listArray[] = $linkList;
    }

    public function buildTab() {
        echo('<nav class="sw-c-tabs">');

        foreach($this->tabArray as $tab) {
            $tab->build($this->user);
        }

        echo('</nav>');
    }

    public function buildList() {
        foreach($this->listArray as $list) {
            $list->build($this->user);
        }
    }

    public function findActive($listID = null, $linkTitle = null) {
        if($listID) {
            foreach($this->tabArray as $tab) {
                if($tab->listID == $listID) {
                    $tab->active = true;
                }
            }
        }

        if($linkTitle) {
            foreach($this->listArray as $list) {
                if($list->listID == $listID) {
                    $list->active = true;

                    foreach($list->linkList as $link) {
                        if($link->title == $linkTitle) {
                            $link->active = true;
                        }
                    }
                }
            }
        }
    }
}