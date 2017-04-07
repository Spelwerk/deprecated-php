<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 22:31
 */
global $sitemap, $user, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = null;

$world = isset($_POST['item--world_id'])
    ? new World($_POST['item--world_id'])
    : null;

$species = isset($_POST['item--species_id'])
    ? new Species($_POST['item--species_id'])
    : null;

$system = new System();
$system->createPerson($person, $world, $species);
?>

<script src="/js/validation.js"></script>