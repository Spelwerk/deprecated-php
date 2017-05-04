<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 09:17
 */
global $user, $component, $curl;

$component->title('Content');

// Creation Links
$component->h1('Create');
$component->linkButton('/content/world/new','New World');

// World List
$component->h1('Worlds');

$userList = $user->isActive
    ? $user->getWorld()
    : null;

if($userList) {
    foreach($userList as $item) {
        $component->linkButton('content/world/id/'.$item['id'], $item['name']);
    }
}

?>

