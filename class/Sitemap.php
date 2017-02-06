<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:12
 */
class Sitemap {

    var $requestURI, $scriptName, $command, $protected, $page, $unique;

    public function __construct() {
        $this->requestURI = explode('/', $_SERVER['REQUEST_URI']);
        $this->scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < sizeof($this->scriptName); $i++) {
            if ($this->requestURI[$i] == $this->scriptName[$i]) {
                unset($this->requestURI[$i]);
            }
        }

        $this->command = array_values($this->requestURI);
    }

    public function buildMap() {
        $this->switchTop();
    }

    function switchTop() {

        $switch = isset($this->command[0]) && $this->command[0] != null
            ? $this->command[0]
            : null;

        switch($switch)
        {
            case 'play':
                $this->switchPlay();
                break;

            case 'story':
                break;

            case 'rule':
                break;

            case 'admin':
                $this->protected = true;
                break;

            case 'user':
                break;

            case 'news':
                break;

            case 'world':
                break;

            default: break;
        }
    }

    function switchPlay() {

        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $unique = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch)
        {
            case 'new':
                $this->page = 'site/play/new.php';
                $this->unique = $unique;
                break;

            case 'edit':
                $this->page = 'site/play/edit.php';
                $this->unique = $unique;
                break;

            case 'play':
                $this->page = 'site/play/play.php';
                $this->unique = $unique;
                break;

            case 'view':
                $this->page = 'site/play/view.php';
                $this->unique = $unique;
                break;

            default: break;
        }
    }
}

/*

/play
/play/new
/play/new/{hash}
/play/edit/{hash}
/play/edit/{hash}/{thing}
/play/play/{hash}
/play/play/{hash}/{tab}
/play/view/{id}
/play/view/{id}/{tab}

/story
/story/new
/story/view/{id}
/story/view/{hash}
/story/edit/{hash}

/rule
/rule/new
/rule/view/{id}
/rule/edit/{id}

/admin
/admin/database
/admin/database/{table}
/admin/database/{table}/new
/admin/database/{table}/view/{id}
/admin/database/{table}/edit/{id}
/admin/user
/admin/user/new
/admin/user/view/{id}
/admin/user/edit/{id}
/admin/usergroup
/admin/usergroup/new
/admin/usergroup/view/{id}
/admin/usergroup/edit/{id}
/admin/promotion
/admin/promotion/new
/admin/promotion/view/{id}
/admin/promotion/edit/{id}
/admin/permission
/admin/permission/new
/admin/permission/view/{id}
/admin/permission/edit/{id}
/admin/rule
/admin/rule/new
/admin/rule/view/{id}
/admin/rule/edit/{id}
/admin/news
/admin/news/new
/admin/news/view/{id}
/admin/news/edit/{id}

/user
/user/new
/user/verify
/user/verify/send
/user/verify/{email}/{hash}
/user/recovery
/user/recovery/send
/user/recovery/password
/user/login
/user/logout
/user/view
/user/view/{id}
/user/edit
/user/edit/email
/user/edit/profile
/user/edit/password

/news
/news/{id}
/news/{id}/comment
/news/{id}/comment/view/{id}
/news/{id}/comment/edit/{id}

/world
/world/new
/world/view/{id}
/world/edit/{id}


*/