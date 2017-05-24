<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('World');
        $component->returnButton('/content');
        $system->listWorld();
        $component->h4('Create');
        $component->linkButton('/content/world/create','Create New');
        break;

    case 'create':
        $system->createWorld();
        break;

    case 'id':
        require_once('./site/content/world/id.php');
        break;
}
?>