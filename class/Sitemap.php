<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:12
 */

class Sitemap {

    var $requestURI, $scriptName, $command;

    var $page, $id, $hash, $context, $unique, $thing, $do;

    var $menuID, $menuLink;

    var $isAdmin, $isUser;

    var $command0, $command1, $command2, $command3, $command4, $command5, $command6, $command7, $command8, $command9;

    public function __construct($user = null) {
        $this->requestURI = explode('/', $_SERVER['REQUEST_URI']);
        $this->scriptName = explode('/', $_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < sizeof($this->scriptName); $i++) {
            if ($this->requestURI[$i] == $this->scriptName[$i]) {
                unset($this->requestURI[$i]);
            }
        }

        $this->command = array_values($this->requestURI);

        $this->command0 = isset($this->command[0]) && $this->command[0] != null
            ? $this->command[0]
            : null;

        $this->command1 = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $this->command2 = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $this->command3 = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        $this->command4 = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $this->command5 = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        $this->command6 = isset($this->command[6]) && $this->command[6] != null
            ? $this->command[6]
            : null;

        $this->command7 = isset($this->command[7]) && $this->command[7] != null
            ? $this->command[7]
            : null;

        $this->command8 = isset($this->command[8]) && $this->command[8] != null
            ? $this->command[8]
            : null;

        $this->command9 = isset($this->command[9]) && $this->command[9] != null
            ? $this->command[9]
            : null;

        $this->switch_top();

        if($this->isAdmin && $user && !$user->isAdmin) {
            $this->page = 'page/error/not_admin.php';
        }

        if($this->isUser && !$user->id) {
            $this->page = 'page/error/not_user.php';
        }
    }

    function switch_top() {
        $switch = $this->command0;

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
        $switch = $this->command1;

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
        $switch = $this->command2;

        switch ($switch) {
            default:
                $this->page = 'page/admin/content/content.php';
                break;
        }
    }

    function switch_admin_person() {
        $switch = $this->command2;

        switch ($switch) {
            default:
                $this->page = 'page/admin/person/person.php';
                break;
        }
    }

    function switch_admin_story() {
        $switch = $this->command2;

        switch ($switch) {
            default:
                $this->page = 'page/admin/story/story.php';
                break;
        }
    }

    function switch_admin_user() {
        $switch = $this->command2;

        switch ($switch) {
            default:
                $this->page = 'page/admin/user/user.php';
                break;
        }
    }

    function switch_content() {
        $switch = $this->command1;

        switch($switch) {
            default:
                $this->page = 'page/content/content.php';
                $this->menuLink = 'Content';
                break;

            case 'about':
                $this->page = 'page/content/about.php';
                $this->menuLink = 'About';
                break;

            case 'manage':
                $this->page = 'page/content/manage.php';
                $this->menuLink = 'Manage';
                break;

            case 'world':
                $this->switch_content_world();
                $this->menuLink = 'Manage';
                break;
        }
    }

    function switch_content_world() {
        $switch = $this->command2;
        $id = $this->command3;

        switch ($switch) {
            default:
                $this->page = 'page/content/world/new.php';
                break;

            case 'id':
                $this->switch_content_world_id();
                $this->id = $id;
                break;
        }
    }

    function switch_content_world_id() {
        $switch = $this->command4;
        $context = $this->command5;

        switch ($switch) {
            default:
                $this->page = 'page/content/world/id.php';
                break;

            case 'attribute':
                $this->page = 'page/content/world/has/attribute.php';
                $this->context = $context;
                break;

            case 'background':
                $this->page = 'page/content/world/has/background.php';
                $this->context = $context;
                break;

            case 'bionic':
                $this->page = 'page/content/world/has/bionic.php';
                $this->context = $context;
                break;

            case 'expertise':
                $this->page = 'page/content/world/has/expertise.php';
                $this->context = $context;
                break;

            case 'gift':
                $this->page = 'page/content/world/has/gift.php';
                $this->context = $context;
                break;

            case 'imperfection':
                $this->page = 'page/content/world/has/imperfection.php';
                $this->context = $context;
                break;

            case 'manifestation':
                $this->page = 'page/content/world/has/manifestation.php';
                $this->context = $context;
                break;

            case 'milestone':
                $this->page = 'page/content/world/has/milestone.php';
                $this->context = $context;
                break;

            case 'protection':
                $this->page = 'page/content/world/has/protection.php';
                $this->context = $context;
                break;

            case 'skill':
                $this->page = 'page/content/world/has/skill.php';
                $this->context = $context;
                break;

            case 'species':
                $this->page = 'page/content/world/has/species.php';
                $this->context = $context;
                break;

            case 'weapon':
                $this->page = 'page/content/world/has/weapon.php';
                $this->context = $context;
                break;
        }
    }

    function switch_play() {
        $switch = $this->command1;

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
        $switch = $this->command2;

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
        $switch = $this->command2;

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
        $id = $this->command3;
        $hash = $this->command4;
        $switch = $this->command5;

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
        $switch = $this->command6;
        $context = $this->command7;

        switch($switch) {
            default:
                $this->page = 'page/play/person/cheat/cheat.php';
                break;

            case 'attribute':
                $this->page = 'page/play/person/cheat/attribute.php';
                $this->unique = $context;
                break;

            case 'Gift':
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
        $switch = $this->command6;
        $context = $this->command7;

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
        $switch = $this->command2;

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
        $id = $this->command3;
        $hash = $this->command4;
        $switch = $this->command5;
        $context = $this->command6;

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
        $switch = $this->command1;
        $context = $this->command2;
        $hash = $this->command3;

        switch($switch) {
            default:
                $this->page = 'page/user/user.php';
                $this->menuLink = 'Login';
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

            case 'sent':
                $this->page = 'page/user/sent.php';
                $this->menuLink = 'Login';
                break;

            case 'me':
                $this->page = 'page/user/me.php';
                $this->menuLink = 'Me';
                break;
        }
    }
}
