<?php

require_once('menu/MenuTab.php');
require_once('menu/MenuList.php');
require_once('menu/MenuLink.php');

class Menu {
    var $tabArray, $listArray;

    var $user;

    public function __construct() {
        global $user;

        $this->user = $user;
        $this->tabArray = [];
        $this->listArray = [];

        $this->addTab('Home', 'Home', '/img/tab-home.png');
        $this->addTab('Play', 'Play', '/img/tab-play.png');
        $this->addTab('Content', 'Content', '/img/tab-content.png');
        $this->addTab('User', 'User', '/img/tab-user.png');
        //$this->addTab('Admin', 'Admin', '/img/tab-admin.png',true,true);

        $menuHome = new MenuList('Home');
        $menuHome->add('Home', '/');
        $menuHome->add('Play', '/play');
        $menuHome->add('Content', '/content');
        $menuHome->add('Login', '/user/login');
        $menuHome->add('Logout', '/user/logout',true);

        $menuPlay = new MenuList('Play');
        $menuPlay->add('Play', '/play');
        $menuPlay->add('Person', '/play/person');
        $menuPlay->add('Story', '/play/story');

        $menuContent = new MenuList('Content');
        $menuContent->add('Content', '/content');
        $menuContent->add('About', '/content/about');

        //$menuAdmin = new MenuList('Admin', true, true);
        //$menuAdmin->add('Admin', '/admin',true,true);

        $menuUser = new MenuList('User');
        if(!$user->isActive) {
            $menuUser->add('User', '/user');
            $menuUser->add('Login', '/user/login');
            $menuUser->add('New', '/user/new');
        } else {
            $menuUser->add('User', '/user/'.$user->id,true);
            $menuUser->add('Logout', '/user/logout',true);
        }

        //$this->addList($menuAdmin);
        $this->addList($menuContent);
        $this->addList($menuHome);
        $this->addList($menuPlay);
        $this->addList($menuUser);
    }

    public function addTab($title, $listID, $icon, $user = null, $admin = false) {
        $this->tabArray[] = new MenuTab($title, $listID, $icon, $user, $admin);
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