<?php global $component, $sitemap, $system, $user;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Person');

    $world = isset($_POST['item--world_id']) ? new World($_POST['item--world_id']) : null;
    $species = isset($_POST['item--species_id']) ? new Species($_POST['item--species_id']) : null;

    $system->createPerson($world, $species);
} else {
    $component->title('Person');
    $component->returnButton('/play');

    if($user->isActive) $component->linkAction('/play/person/create','Create Person','A person, or a character, is what you use to play the game.','/img/link-person-w.png',false,'sw-is-green');

    $system->listPerson();
}
?>