<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 10:55
 */

global $system;

$person = isset($_GET['hash'])
    ? new Person(null, $_GET['hash'])
    : null;

$world = isset($_POST['person--world_id'])
    ? new World($_POST['person--world_id'])
    : null;

$species = isset($_POST['person--species_id'])
    ? new Species($_POST['person--species_id'])
    : null;

$system->createPerson($person, $world, $species);

?>