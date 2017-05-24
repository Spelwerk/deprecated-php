<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Person');
        $component->returnButton('/play');
        $system->listPerson();
        $component->h4('Create');
        $component->linkAction('/play/person/create','Create Person','A person, or a character, is what you use to play the game.','/img/link-person-w.png');
        break;

    case 'create':
        $component->title('Create Person');

        $world = isset($_POST['item--world_id'])
            ? new World($_POST['item--world_id'])
            : null;

        $species = isset($_POST['item--species_id'])
            ? new Species($_POST['item--species_id'])
            : null;

        $system->createPerson($world, $species);
        break;

    case 'id':
        require_once('./site/play/person/id.php');
        break;
}
?>