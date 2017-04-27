<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 22:31
 */
global $sitemap, $user, $form, $component;

require_once('./class/World.php');
require_once('./class/System.php');

$system = new System();

$world = isset($_POST['item--world_id'])
    ? new World($_POST['item--world_id'])
    : null;

$species = isset($_POST['item--species_id'])
    ? new Species($_POST['item--species_id'])
    : null;

$system->createPerson($world, $species);
?>

<script src="/js/validation.js"></script>