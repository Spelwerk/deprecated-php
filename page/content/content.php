<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 09:17
 */
global $user, $component, $curl;

$speciesList = $user->isActive ? $user->getSpecies() : null;
$worldList = $user->isActive ? $user->getWorld() : null;

$component->title('Content');

// Creation Links
$component->h1('Create');
$component->linkButton('/content/species/new','New Species');
$component->linkButton('/content/world/new','New World');

// Species List
if($speciesList) {
    $component->h2('Species');

    foreach($speciesList as $item) {
        $component->linkButton('content/species/id/'.$item['id'], $item['name']);
    }
}

// World List
if($worldList) {
    $component->h2('Worlds');

    foreach($worldList as $item) {
        $component->linkButton('content/world/id/'.$item['id'], $item['name']);
    }
}

?>

