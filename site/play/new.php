<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 10:55
 */
global $sitemap;

$system = new System();

$person = isset($sitemap->unique)
    ? new Person(null, $sitemap->unique)
    : null;

$world = isset($_POST['person--world_id'])
    ? $world = new World($_POST['person--world_id'])
    : null;

$species = isset($_POST['person--species_id'])
    ? new Species($_POST['person--species_id'])
    : null;

$system->createPerson($person, $world, $species);

?>