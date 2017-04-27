<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 13:26
 */
global $sitemap, $user, $form, $component;

require_once('./class/System.php');
require_once('./class/World.php');

$system = new System();

$world = isset($_POST['item--world_id'])
    ? new World($_POST['item--world_id'])
    : null;

$system->createStory($world);
?>

<script src="/js/validation.js"></script>