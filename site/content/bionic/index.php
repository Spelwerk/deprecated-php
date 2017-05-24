<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Bionic');
        $component->returnButton('/content');
        $system->listBionic();
        $component->h4('Create');
        $component->linkButton('/content/bionic/create','Create New');
        break;

    case 'create':
        $system->createBionic();
        break;

    case 'id':
        require_once('./site/content/bionic/id.php');
        break;
}
?>