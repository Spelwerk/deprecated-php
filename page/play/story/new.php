<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 13:26
 */
global $sitemap, $user, $form, $component;

require_once('./class/Story.php');
require_once('./class/System.php');

$story = null;

$world = isset($_POST['item--world_id'])
    ? new World($_POST['item--world_id'])
    : null;

$system = new System();
$system->createStory($story, $world);
?>

<script src="/js/validation.js"></script>