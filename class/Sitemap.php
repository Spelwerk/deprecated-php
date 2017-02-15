<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:12
 */
class Sitemap {

    var $requestURI, $scriptName, $command;

    var $page, $id, $hash, $thing, $unique;

    var $isAdmin, $isUser;

    public function __construct() {
        $this->requestURI = explode('/', $_SERVER['REQUEST_URI']);
        $this->scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < sizeof($this->scriptName); $i++) {
            if ($this->requestURI[$i] == $this->scriptName[$i]) {
                unset($this->requestURI[$i]);
            }
        }

        $this->command = array_values($this->requestURI);

        $this->switchTop();
    }

    function switchTop() {

        $switch = isset($this->command[0]) && $this->command[0] != null
            ? $this->command[0]
            : null;

        $id = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/default.php';
                break;

            case 'play':
                $this->switchPlay();
                break;

            case 'user':
                $this->switchUser();
                break;

            case 'view':
                $this->switchView();
                break;

            case 'world':
                $this->switchWorld();
                break;

            case 'error':
                $this->page = 'site/error.php';
                $this->id = $id;
                break;
        }
    }

    function switchPlay() {
        $id = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $hash = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $switch = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/play/default.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'cheat':
                $this->switchPlayCheat();
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'level':
                $this->switchPlayLevel();
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'wound':
                $this->page = 'site/play/wound.php';
                break;
        }
    }

    function switchPlayLevel() {
        $switch = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $thing = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/play/level/default.php';
                break;

            case 'bionic':
                $this->page = 'site/play/level/bionic.php';
                break;

            case 'experience':
                $this->page = 'site/play/level/experience.php';
                break;

            case 'expertise':
                $this->page = 'site/play/level/expertise.php';
                break;

            case 'protection':
                $this->page = 'site/play/level/protection.php';
                break;

            case 'skill':
                $this->page = 'site/play/level/skill.php';
                break;

            case 'supernatural':
                $this->page = 'site/play/level/supernatural.php';
                break;

            case 'weapon':
                $this->page = 'site/play/level/weapon.php';
                $this->thing = $thing;
                break;
        }
    }

    function switchPlayCheat() {
        $switch = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        $thing = isset($this->command[5]) && $this->command[5] != null
            ? $this->command[5]
            : null;

        $unique = isset($this->command[6]) && $this->command[6] != null
            ? $this->command[6]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/play/cheat/default.php';
                break;

            case 'attribute':
                $this->page = 'site/play/cheat/attribute.php';
                $this->unique = $thing;
                break;

            case 'bionic':
                $this->page = 'site/play/cheat/bionic.php';
                break;

            case 'characteristic':
                $this->page = 'site/play/cheat/characteristic.php';
                $this->thing = $thing;
                break;

            case 'expertise':
                $this->page = 'site/play/cheat/expertise.php';
                break;

            case 'feature':
                $this->page = 'site/play/cheat/feature.php';
                $this->thing = $thing;
                break;

            case 'milestone':
                $this->page = 'site/play/cheat/milestone.php';
                $this->thing = $thing;
                break;

            case 'protection':
                $this->page = 'site/play/cheat/protection.php';
                break;

            case 'skill':
                $this->page = 'site/play/cheat/skill.php';
                break;

            case 'supernatural':
                $this->page = 'site/play/cheat/supernatural.php';
                break;

            case 'weapon':
                $this->page = 'site/play/cheat/weapon.php';
                $this->thing = $thing;
                break;
        }
    }

    function switchUser() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $hash = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/user/default.php';
                break;

            case 'new':
                $this->switchUserNew();
                break;

            case 'login':
                $this->switchUserLogin();
                break;

            case 'cheat':
                $this->page = 'site/user/edit.php';
                break;

            case 'reset':
                $this->page = 'site/user/reset.php';
                break;

            case 'password':
                $this->page = 'site/user/password.php';
                $this->hash = $hash;
                break;
        }
    }

    function switchUserNew() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $hash = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        switch ($switch)
        {
            default:
                $this->page = 'site/user/new/default.php';
                break;

            case 'verify':
                $this->page = 'site/user/new/verify.php';
                $this->hash = $hash;
                break;

            case 'timeout':
                $this->page = 'site/user/new/timeout.php';
                break;
        }
    }

    function switchUserLogin() {
        $switch = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $hash = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        switch ($switch)
        {
            default:
                $this->page = 'site/user/login/default.php';
                break;

            case 'mail':
                $this->page = 'site/user/login/mail.php';
                break;

            case 'pass':
                $this->page = 'site/user/login/pass.php';
                break;

            case 'verify':
                $this->page = 'site/user/login/verify.php';
                $this->hash = $hash;
                break;
        }
    }

    function switchView() {
        $switch = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $id = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        switch($switch)
        {
            default:
                break;

            case 'person':
                $this->page = 'site/view/person.php';
                $this->id = $id;
                break;
        }
    }

    function switchWorld() {
        $id = isset($this->command[1]) && $this->command[1] != null
            ? $this->command[1]
            : null;

        $hash = isset($this->command[2]) && $this->command[2] != null
            ? $this->command[2]
            : null;

        $switch = isset($this->command[3]) && $this->command[3] != null
            ? $this->command[3]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/world/default.php';
                $this->id = $id;
                $this->hash = $hash;
                break;

            case 'cheat':
                $this->switchPlayEdit();
                break;
        }
    }
}