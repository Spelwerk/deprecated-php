<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Manifestation');
        $component->returnButton('/content');
        $system->listManifestation();
        $component->h4('Create');
        $component->linkButton('/content/manifestation/create','Create New');
        break;

    case 'create':
        $system->createManifestation();
        break;

    case 'id':
        require_once('./site/content/manifestation/id.php');
        break;
}
?>