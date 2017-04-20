<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:12
 */

class Sitemap {

    var $requestURI, $scriptName, $command;

    var $page, $id, $hash, $context, $unique, $thing;

    var $menuID, $menuLink;

    var $isAdmin, $isUser;

    public function __construct($user = null) {
        $this->requestURI = explode('/', $_SERVER['REQUEST_URI']);
        $this->scriptName = explode('/', $_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < sizeof($this->scriptName); $i++) {
            if ($this->requestURI[$i] == $this->scriptName[$i]) {
                unset($this->requestURI[$i]);
            }
        }

        $this->command = array_values($this->requestURI);

        $this->switch_top();

        if($this->isAdmin && $user && !$user->isAdmin) {
            $this->page = 'page/error/not_admin.php';
        }

        if($this->isUser && !$user->id) {
            $this->page = 'page/error/not_user.php';
        }
    }

    function switch_top() {
        $switch = isset($this->command[0]) && $this->command[0] != null
            ? $this->command[0]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/home.php';
                $this->menuID = 'Home';
                $this->menuLink = 'Home';
                break;

            case 'about':
                $this->page = 'page/about.php';
                $this->menuID = 'Home';
                $this->menuLink = 'About';
                break;

            case 'admin':
                $this->switch_admin();
                $this->isUser = true;
                $this->isAdmin = true;
                $this->menuID = 'Admin';
                break;

            case 'content':
                $this->switch_content();
                $this->isUser = true;
                $this->menuID = 'Content';
                break;

            case 'play':
                $this->switch_play();
                $this->menuID = 'Play';
                break;

            case 'user':
                $this->switch_user();
                $this->menuID = 'User';
                break;
        }
    }

    function switch_admin() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/admin/admin.php';
                $this->menuLink = 'Admin';
                break;

            case 'content':
                $this->switch_admin_content();
                $this->menuLink = 'Content';
                break;

            case 'person':
                $this->switch_admin_person();
                $this->menuLink = 'Person';
                break;

            case 'story':
                $this->switch_admin_story();
                $this->menuLink = 'Story';
                break;

            case 'user':
                $this->switch_admin_user();
                $this->menuLink = 'User';
                break;
        }
    }

    function switch_admin_content() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch ($switch) {
            default:
                $this->page = 'page/admin/content/content.php';
                break;
        }
    }

    function switch_admin_person() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch ($switch) {
            default:
                $this->page = 'page/admin/person/person.php';
                break;
        }
    }

    function switch_admin_story() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch ($switch) {
            default:
                $this->page = 'page/admin/story/story.php';
                break;
        }
    }

    function switch_admin_user() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch ($switch) {
            default:
                $this->page = 'page/admin/user/user.php';
                break;
        }
    }

    function switch_content() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/content/content.php';
                $this->menuLink = 'Content';
                break;

            case 'about':
                $this->page = 'page/content/about.php';
                $this->menuLink = 'About';
                break;

            case 'create':
                $this->page = 'page/content/create.php';
                $this->menuLink = 'Create';
                break;

            case 'manage':
                $this->switch_content_manage();
                $this->menuLink = 'Manage';
                break;
        }
    }

    function switch_content_manage() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch ($switch) {
            default:
                $this->page = 'page/content/manage/manage.php';
                break;
        }
    }

    function switch_play() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/play.php';
                $this->menuLink = 'Play';
                break;

            case 'companion':
                $this->switch_play_companion();
                $this->menuLink = 'Companion';
                break;

            case 'person':
                $this->switch_play_person();
                $this->menuLink = 'Person';
                break;

            case 'story':
                $this->switch_play_story();
                $this->menuLink = 'Story';
                break;
        }
    }

    function switch_play_companion() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/companion/companion.php';
                break;

            case 'add':
                break;

            case 'id':
                break;
        }
    }

    function switch_play_person() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/person/person.php';
                break;

            case 'new':
                $this->page = 'page/play/person/new.php';
                break;

            case 'id':
                $this->switch_play_person_id();
                break;
        }
    }

    function switch_play_person_id() {
        $id = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        $hash = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $switch = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/person/id.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'disease':
                $this->page = 'page/play/person/wound/disease.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'cheat':
                $this->switch_play_person_id_cheat();
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'edit':
                $this->switch_play_person_id_edit();
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'sanity':
                $this->page = 'page/play/person/wound/sanity.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'wound':
                $this->page = 'page/play/person/wound/wound.php';
                $this->id = $id;
                $this->hash = $hash;
                break;
        }
    }

    function switch_play_person_id_cheat() {
        $switch = isset($this->command[6]) && $this->command[6] != null
            ? $this->command[6]
            : null;

        $context = isset($this->command[7]) && $this->command[7] != null
            ? $this->command[7]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/person/cheat/cheat.php';
                break;

            case 'attribute':
                $this->page = 'page/play/person/cheat/attribute.php';
                $this->unique = $context;
                break;

            case 'characteristic':
                $this->page = 'page/play/person/cheat/characteristic.php';
                $this->context = $context;
                break;

            case 'doctrine':
                $this->page = 'page/play/person/cheat/doctrine.php';
                break;

            case 'expertise':
                $this->page = 'page/play/person/cheat/expertise.php';
                break;

            case 'feature':
                $this->page = 'page/play/person/cheat/feature.php';
                $this->context = $context;
                break;

            case 'milestone':
                $this->page = 'page/play/person/cheat/milestone.php';
                $this->context = $context;
                break;

            case 'skill':
                $this->page = 'page/play/person/cheat/skill.php';
                break;
        }
    }

    function switch_play_person_id_edit() {
        $switch = isset($this->command[6]) && $this->command[6] != null
            ? $this->command[6]
            : null;

        $context = isset($this->command[7]) && $this->command[7] != null
            ? $this->command[7]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/person/edit/edit.php';
                break;

            case 'augmentation':
                $this->page = 'page/play/person/edit/augmentation.php';
                $this->context = $context;
                break;

            case 'bionic':
                $this->page = 'page/play/person/edit/bionic.php';
                break;

            case 'consumable':
                $this->page = 'page/play/person/edit/consumable.php';
                $this->context = $context;
                break;

            case 'description':
                $this->page = 'page/play/person/edit/description.php';
                break;

            case 'experience':
                $this->page = 'page/play/person/edit/experience.php';
                break;

            case 'expertise':
                $this->page = 'page/play/person/edit/expertise.php';
                break;

            case 'milestone':
                $this->page = 'page/play/person/edit/milestone.php';
                break;

            case 'protection':
                $this->page = 'page/play/person/edit/protection.php';
                $this->context = $context;
                break;

            case 'skill':
                $this->page = 'page/play/person/edit/skill.php';
                break;

            case 'supernatural':
                $this->page = 'page/play/person/edit/supernatural.php';
                break;

            case 'weapon':
                $this->page = 'page/play/person/edit/weapon.php';
                $this->context = $context;
                break;
        }
    }

    function switch_play_story() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/story/story.php';
                break;

            case 'id':
                $this->switch_play_story_id();
                break;

            case 'new':
                $this->page = 'page/play/story/new.php';
                break;
        }
    }

    function switch_play_story_id() {
        $id = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        $hash = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $switch = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        $context = isset($this->command[6]) && $this->command[6] != null
            ? $this->command[6]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/play/story/id.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'edit':
                $this->page = 'page/play/story/edit.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'location':
                $this->page = 'page/play/story/location.php';
                $this->id = $id;
                $this->hash = $hash;
                $this->context = $context;
                break;

            case 'meeting':
                $this->page = 'page/play/story/meeting.php';
                $this->id = $id;
                $this->hash = $hash;
                $this->context = $context;
                break;

            case 'person':
                $this->page = 'page/play/story/person.php';
                $this->id = $id;
                $this->hash = $hash;
                $this->context = $context;
                break;
        }
    }

    function switch_user() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $context = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $hash = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/user/user.php';
                break;

            case 'new':
                $this->page = 'page/user/new.php';
                $this->context = $context;
                $this->menuLink = 'New';
                break;

            case 'login':
                $this->page = 'page/user/login.php';
                $this->context = $context;
                $this->menuLink = 'Login';
                break;

            case 'logout':
                $this->page = 'page/user/logout.php';
                $this->menuLink = 'Logout';
                break;

            case 'verify':
                $this->page = 'page/user/verify.php';
                $this->context = $context;
                $this->hash = $hash;
                $this->menuLink = 'Login';
                break;

            case 'me':
                $this->page = 'page/user/me.php';
                $this->menuLink = 'Me';
                break;
        }
    }

    function switch_user_me() {

    }
}

/*

/content
/content/{thing}
/content/{thing}/add
/content/{thing}/id/{id}
/content/{thing}/id/{id}/{hash}

 */