<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:12
 */
class Sitemap {

    var $requestURI, $scriptName, $command, $protected, $page, $id, $hash, $unique;

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

        switch($switch)
        {
            default:
                break;

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

            case 'edit':
                $this->switchPlayEdit();
                break;
        }
    }

    function switchPlayEdit() {
        $switch = isset($this->command[4]) && $this->command[4] != null
            ? $this->command[4]
            : null;

        switch($switch)
        {
            default:
                $this->page = 'site/play/edit/default.php';
                break;

            case 'wound':
                $this->page = 'site/play/edit/wound.php';
                break;
        }
    }
}