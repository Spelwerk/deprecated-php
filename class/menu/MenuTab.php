<?php class MenuTab {
    var $title, $listID, $icon, $active, $user, $admin;

    public function __construct($title, $listID, $icon, $user = false, $admin = false) {
        $this->title = $title;
        $this->listID = $listID;
        $this->icon = $icon;
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build($user) {
        if($this->user && !$user->isActive) {}
        else if($this->admin && !$user->isActive) {}
        else if($this->admin && $user->isActive && !$user->isAdmin) {}
        else {
            $class = $this->active
                ? 'sw-js-menu-tab sw-c-item--active'
                : 'sw-js-menu-tab sw-c-item';

            echo('<a class="'.$class.'" title="'.$this->title.'" id="tab__'.$this->listID.'"><img src="'.$this->icon.'"/></a>');
        }
    }
}