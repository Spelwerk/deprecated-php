<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Species');
        $component->returnButton('/content');
        $system->listSpecies();
        $component->h4('Create');
        $component->linkButton('/content/species/create','Create New');
        break;

    case 'create':
        $system->createSpecies();
        break;

    case 'id':
        require_once('./site/content/species/id.php');
        break;
}
?>