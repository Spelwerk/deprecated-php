<?php class Sitemap {
    var $requestURI, $scriptName, $command;

    var $page, $id, $hash, $thing, $do;

    var $index;

    var $context, $context2, $context3;

    var $extra, $extra2, $extra3;

    var $unique;

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
        switch($this->command0) {
            default:
                $this->page = 'page/home.php';
                $this->menuID = 'Home';
                $this->menuLink = 'Home';
                break;

            case 'info':
                $this->page = 'page/info.php';
                $this->menuID = 'Home';
                break;

            case 'content':
                $this->switch_content();
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
        $this->menuLink = 'Content';

        switch($this->command1)
        {
            default:
                $this->page = 'site/content/index.php';
                break;

            case 'augmentation':
                $this->page = 'site/content/augmentation/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'background':
                $this->page = 'site/content/background/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'bionic':
                $this->page = 'site/content/bionic/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'expertise':
                $this->page = 'site/content/expertise/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'gift':
                $this->page = 'site/content/gift/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'imperfection':
                $this->page = 'site/content/imperfection/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'manifestation':
                $this->page = 'site/content/manifestation/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'milestone':
                $this->page = 'site/content/milestone/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'protection':
                $this->page = 'site/content/protection/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'skill':
                $this->page = 'site/content/skill/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'software':
                $this->page = 'site/content/software/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'species':
                $this->page = 'site/content/species/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'weapon':
                $this->page = 'site/content/weapon/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'weapongroup':
                $this->page = 'site/content/weapongroup/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'weapontype':
                $this->page = 'site/content/weapontype/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;

            case 'world':
                $this->page = 'site/content/world/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                break;
        }
    }

    function switch_play() {
        switch($this->command1) {
            default:
                $this->menuLink = 'Play';
                $this->page = 'site/play/index.php';
                break;

            case 'person':
                $this->menuLink = 'Person';
                $this->page = 'site/play/person/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                $this->extra2 = $this->command5;
                $this->extra3 = $this->command6;
                break;

            case 'story':
                $this->menuLink = 'Story';
                $this->page = 'site/play/story/index.php';
                $this->index = $this->command2;
                $this->context = $this->command3;
                $this->extra = $this->command4;
                $this->extra2 = $this->command5;
                break;
        }
    }

    function switch_user() {
        switch($this->command1) {
            default:
                $this->menuLink = 'User';
                $this->page = 'site/user/index.php';
                $this->index = $this->command1;
                break;

            case 'create':
                $this->menuLink = 'New';
                $this->page = 'site/user/create/index.php';
                $this->index = $this->command2;
                $this->hash = $this->command3;
                break;

            case 'login':
                $this->menuLink = 'Login';
                $this->page = 'site/user/login/index.php';
                $this->index = $this->command2;
                $this->hash = $this->command3;
                break;

            case 'password':
                $this->menuLink = 'User';
                $this->page = 'site/user/password/index.php';
                $this->index = $this->command2;
                $this->hash = $this->command3;
                break;

            case 'email':
                $this->menuLink = 'User';
                $this->page = 'site/user/email/index.php';
                $this->index = $this->command2;
                $this->hash = $this->command3;
                break;

            case 'logout':
                $this->menuLink = 'Logout';
                $this->page = 'page/user/logout.php';
                break;
        }
    }
}