<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Background');
        $component->returnButton('/content');
        $system->listBackground();
        $component->h4('Create');
        $component->linkButton('/content/background/create','Create New');
        break;

    case 'create':
        $system->createBackground();
        break;

    case 'id':
        require_once('./site/content/background/id.php');
        break;
}
?>