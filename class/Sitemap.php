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

    function switch_content() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        switch($switch) {
            default:
                $this->page = 'page/content/content.php';
                $this->menuLink = 'Content';
                break;

            case 'manifestation':
                $this->menuLink = 'Content';
                break;

            case 'world':
                $this->menuLink = 'World';
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

            case 'add':
                $this->page = 'page/play/person/add.php';
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
                $this->page = 'page/play/person/disease.php';
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
                $this->page = 'page/play/person/sanity.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'wound':
                $this->page = 'page/play/person/wound.php';
                $this->id = $id;
                $this->hash = $hash;
                break;
        }
    }

    function switch_play_person_id_cheat() {
        $switch = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $context = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
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
        $switch = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $context = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        switch($switch) {
            default:
                $this->page = 'play/person/edit/edit.php';
                break;

            case 'augmentation':
                $this->page = 'play/person/edit/augmentation.php';
                break;

            case 'bionic':
                $this->page = 'play/person/edit/bionic.php';
                break;

            case 'consumable':
                $this->page = 'play/person/edit/consumable.php';
                $this->context = $context;
                break;

            case 'description':
                $this->page = 'play/person/edit/description.php';
                break;

            case 'experience':
                $this->page = 'play/person/edit/experience.php';
                break;

            case 'expertise':
                $this->page = 'play/person/edit/expertise.php';
                break;

            case 'milestone':
                $this->page = 'play/person/edit/milestone.php';
                break;

            case 'protection':
                $this->page = 'play/person/edit/protection.php';
                $this->context = $context;
                break;

            case 'skill':
                $this->page = 'play/person/edit/skill.php';
                break;

            case 'supernatural':
                $this->page = 'play/person/edit/supernatural.php';
                break;

            case 'weapon':
                $this->page = 'play/person/edit/weapon.php';
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

            case 'add':
                break;

            case 'id':
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

            case 'add':
                $this->page = 'page/user/add.php';
                $this->context = $context;
                $this->menuLink = 'Add';
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

/

  /play
  /play/person
  /play/person/add
  /play/person/id/{id}
  /play/person/id/{id}/{hash}
  /play/person/id/{id}/{hash}/edit
  /play/person/id/{id}/{hash}/edit/{thing}

/play/story
/play/story/add
/play/story/id/{id}
/play/story/id/{id}/{hash}
/play/story/id/{id}/{hash}/edit
/play/story/id/{id}/{hash}/edit/{thing}

/content
/content/{thing}
/content/{thing}/add
/content/{thing}/id/{id}
/content/{thing}/id/{id}/{hash}

/user
  /user/add
  /user/add/timeout
  /user/login
  /user/login/email
  /user/login/reset
  /user/verify/add
  /user/verify/add/{hash}
  /user/verify/reset
  /user/verify/reset/{hash}
  /user/verify/login
  /user/verify/login/{hash}
  /user/logout
/user/me
/user/me/edit
/user/me/edit/{thing}
/user/name/{displayname}

 */